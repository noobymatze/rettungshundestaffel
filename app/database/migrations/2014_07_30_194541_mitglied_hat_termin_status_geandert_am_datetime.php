<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MitgliedHatTerminStatusGeandertAmDatetime extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('mitglied_hat_termin', function($table) 
        {
            $table->dropColumn('status_geandert_am');
            $table->datetime('status_geaendert_am');
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
            $table->dropColumn('status_geaendert_am');
            $table->date('status_geandert_am');
        });
	}

}
