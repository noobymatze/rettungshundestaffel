<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FuegeKoordinateZuAdresseTabelleHinzu extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// POINT wird nicht von Laravel unterstützt,
        // deswegen manuell:
        DB::statement('ALTER TABLE adresse ADD koordinate POINT NULL');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('adresse', function(Blueprint $table)
		{
			$table->dropColumn('koordinate');
		});
	}

}
