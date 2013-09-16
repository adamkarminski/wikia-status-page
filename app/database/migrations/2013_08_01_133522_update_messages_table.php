<?php

use Illuminate\Database\Migrations\Migration;

class UpdateMessagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('messages', function($table){
			$table->integer('flag')->after('message');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('messages', function($table){
			$table->dropColumn('flag');
		});
	}

}