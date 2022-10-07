<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $token = auth()->attempt($validator->validate());

        if (!$token) {
            return response()->json(['sucess' => false, 'msg' => 'Username & password incorrect']);
        }

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'success' => true,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'type_user' => 'required|integer',
            'email' => 'required|string|email|max:255|unique:user__manager',
            'password' => 'required|string|min:8|regex:"^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}(?=.*[@#$%^&+=]).*$"',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'name' => $request->name,
            'type_user' => $request->type_user,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'state' => 2,
            'first_login' => 1,
        ]);

        $random = Str::random(40);
        $domain = URL::to('/');
        $url = $domain . '/verify-mail/' . $random;

        $data['url'] = $url;
        $data['email'] = $user->email;
        $data['title'] = "Email Verification";
        $data['body'] = "Solo da click en siguiente botón para que cada viaje sea una gran experiencia";
        Mail::send('verifyMail', ['data' => $data], function ($message) use ($data) {
            $message->to($data['email'])->subject($data['title']);
        });

        return $this->verificarCorreo($user->email, $random);
    }

    public function verificarCorreo($email, $random)
    {
        $user = User::where('email', $email)->get();

        $user = User::find($user[0]['id']);
        $user->rememberToken = $random;
        $user->save();


        return response()->json([
            'success' => true,
            'message' => 'User created successfully!! we have sent an email to your inbox please check your email',
            'user' => $user,

        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }


    public function verificationMail($token)
    {
        $user =  User::where('rememberToken', $token)->get();

        if (!count($user) > 0) {
            return view('404');
        }

        $datetime = Carbon::now()->format('Y-m-d H:i:s');
        $userId = User::find($user[0]['id']);
        $userId->rememberToken = '';
        $userId->is_verified = 1;
        $userId->state = 1;
        $userId->email_verified_at = $datetime;
        $userId->save();
        return "<h1>Email verified successfully!</h1>";
    }
}
