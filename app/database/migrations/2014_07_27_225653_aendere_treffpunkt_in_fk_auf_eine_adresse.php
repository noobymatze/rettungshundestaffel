<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AendereTreffpunktInFkAufEineAdresse extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('suchgebiet', function($table)
		{
			$table->dropForeign('suchgebiet_treffpunkt_foreign');
		    $table->dropColumn(array('treffpunkt'));
		});

		Schema::table('suchgebiet', function(Blueprint $table)
		{
			$table->bigInteger('treffpunkt')->unsigned()->nullable();

			$table->foreign('treffpunkt')
                ->references('id')
                ->on('adresse');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('suchgebiet', function($table)
		{
			$table->dropForeign('suchgebiet_treffpunkt_foreign');
		    $table->dropColumn(array('treffpunkt'));
		});

		Schema::table('suchgebiet', function(Blueprint $table)
		{
			$table->bigInteger('treffpunkt')->unsigned()->nullable();

			$table->foreign('treffpunkt')
                ->references('id')
                ->on('koordinate');
		});
	}

}
