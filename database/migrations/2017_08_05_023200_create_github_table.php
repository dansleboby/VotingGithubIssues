<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGithubTable extends Migration {

	public function up()
	{
		Schema::create('github', function(Blueprint $table) {
			$table->increments('id');
            $table->string('html_url', 255);
            $table->string('title', 255);
            $table->string('state', 20);
            $table->integer('comments');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('github');
	}
}