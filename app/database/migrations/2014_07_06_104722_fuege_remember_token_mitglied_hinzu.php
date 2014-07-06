<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FuegeRememberTokenMitgliedHinzu extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('mitglied', function($table) 
        {
            $table->rememberToken();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('mitglied', function($table) 
        {
            $table->dropColumn('remember_token');
        });
	}

}
