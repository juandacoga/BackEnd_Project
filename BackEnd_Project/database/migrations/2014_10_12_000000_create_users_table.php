<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user__manager', function (Blueprint $table) {
            $table->string('name');
            $table->integer('type_user');
            $table->unique('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('state');
            $table->integer('first_login');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
