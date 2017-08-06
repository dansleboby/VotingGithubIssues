<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->rememberToken();
            $table->string('email', 100);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down() {
        Schema::drop('users');
    }
}