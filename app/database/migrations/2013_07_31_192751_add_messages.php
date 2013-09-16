<?php

use Illuminate\Database\Migrations\Migration;

class AddMessages extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::table('messages')->insert( array(
				'message' => 'Message #1',
				'created_at' => date('2013-07-31 21:30:00'),
				'updated_at' => date('2013-07-31 21:30:00')
			));
		DB::table('messages')->insert( array(
				'message' => 'Message #2',
				'created_at' => date('2013-07-31 21:33:00'),
				'updated_at' => date('2013-07-31 21:33:00')
			));
		DB::table('messages')->insert( array(
				'message' => 'Message #3',
				'created_at' => date('2013-07-31 21:39:00'),
				'updated_at' => date('2013-07-31 21:39:00')
			));
		DB::table('messages')->insert( array(
				'message' => 'Message #4',
				'created_at' => date('2013-07-31 21:45:00'),
				'updated_at' => date('2013-07-31 21:45:00')
			));
		DB::table('messages')->insert( array(
				'message' => 'Message #5',
				'created_at' => date('2013-07-31 21:50:00'),
				'updated_at' => date('2013-07-31 21:50:00')
			));
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::table('messages')->where('message', '=', 'Message #1')->delete();
		DB::table('messages')->where('message', '=', 'Message #2')->delete();
		DB::table('messages')->where('message', '=', 'Message #3')->delete();
		DB::table('messages')->where('message', '=', 'Message #4')->delete();
		DB::table('messages')->where('message', '=', 'Message #5')->delete();
	}

}