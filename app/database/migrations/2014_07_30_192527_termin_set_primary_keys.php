<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TerminSetPrimaryKeys extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('mitglied_hat_termin', function($table) 
        {
            $table->primary(['mitglied_id', 'termin_id']);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('mitglied_hat_termin', function($table) 
        {
            $table->dropPrimary(['mitglied_id', 'termin_id']);
        });
	}

}
