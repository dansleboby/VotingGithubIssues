<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVotesTable extends Migration {

	public function up()
	{
		Schema::create('votes', function(Blueprint $table) {
			$table->integer('user_id')->unsigned()->index();
			$table->integer('github_id')->unsigned()->index();
		});
	}

	public function down()
	{
		Schema::drop('votes');
	}
}