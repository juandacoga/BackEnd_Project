<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ $data['title'] }}</title>
</head>

<body>
    <strong>Hola {{ $data['email'] }}</strong>
    <p>{{ $data['body']}}</p>
    <a href="{{ $data['url']}}">Click here to Verify mail</a>
    <p>Si no solicitaste la activación de tu cuenta, solo ignora este mensaje o comunicate con nosotros en nuestra pagina {{ env('APP_NAME') }} </p>
</body>

</html>