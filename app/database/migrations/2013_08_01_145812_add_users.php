<?php

use Illuminate\Database\Migrations\Migration;

class AddUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::table('users')->insert( array(

				'username' => 'Admin',
				'password' => Hash::make('wikia-inc'),
				'created_at' => date('Y-m-d H:m:s'),
				'updated_at' => date('Y-m-d H:m:s')

			));
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::table('users')->where('username', '=', 'Admin')->delete();
	}

}