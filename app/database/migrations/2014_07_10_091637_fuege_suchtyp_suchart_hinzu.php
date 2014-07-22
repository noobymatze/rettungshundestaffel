<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FuegeSuchtypSuchartHinzu extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('suchart', function(Blueprint $table)
		{
			$table->enum('suchtyp', array('Flaechensuche', 'Mantrailing', 'Truemmersuche', 'Lawinensuche', 'Wasserrettung', 'Wasserortung', 'Leichensuche'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('suchart', function(Blueprint $table)
		{
			$table->dropColumn('suchtyp');
		});
	}

}
