<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdresseZusatzAngepasst extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table(('adresse'), function($tabelle)
		{
			$tabelle->dropColumn('zusatz');
		});
		
		Schema::table(('adresse'), function($tabelle)
		{
			$tabelle->string('zusatz')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table(('adresse'), function($tabelle)
		{
			$tabelle->dropColumn('zusatz');
		});
		Schema::table(('adresse'), function($tabelle)
		{
			$tabelle->string('zusatz');
		});
	}

}
