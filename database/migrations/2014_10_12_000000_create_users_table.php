<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->boolean('is_admin')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
        DB::table('users')->insert([
            'name'      =>  'Janrey Maligro',
            'email'     =>  'malricjan25@admin.com',
            'is_admin'  =>  '1',
            'password'  =>  bcrypt('12345678'),
        ]);
        DB::table('users')->insert([
            'name'      =>  'ADMINISTRATOR',
            'email'     =>  'admin@admin.com',
            'is_admin'  =>  '1',
            'password'  =>  bcrypt('12345678'),
        ]);
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
}
