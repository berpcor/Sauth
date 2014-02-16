<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTableWithSocialAuthFields extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function($table)
		{
			$table->enum('registered_via', array('native', 'vk', 'odnoklassniki', 'mailru', 'yandex', 'google', 'facebook'));
			$table->string('social_id', 255);
			$table->string('social_avatar', 255);

		});
		
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function($table)
		{
			$table->dropColumn('registered_via');
			$table->dropColumn('social_id');
			$table->dropColumn('social_avatar');
		});
	}

}
