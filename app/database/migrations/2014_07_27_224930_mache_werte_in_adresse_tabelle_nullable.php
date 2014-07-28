<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MacheWerteInAdresseTabelleNullable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('adresse', function($table)
		{
		    $table->dropColumn(array('strasse', 'hausnummer', 'postleitzahl', 'ort'));
		});

		Schema::table('adresse', function(Blueprint $table)
        {
            $table->string('strasse')->nullable();
            $table->integer('hausnummer')->nullable();
            $table->string('postleitzahl')->nullable();
            $table->string('ort')->nullable();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement('ALTER TABLE adresse ALTER COLUMN strasse VARCHAR(255) NOT NULL');
		DB::statement('ALTER TABLE adresse ALTER COLUMN hausnummer INT(11) NOT NULL');
		DB::statement('ALTER TABLE adresse ALTER COLUMN postleitzahl VARCHAR(255) NOT NULL');
		DB::statement('ALTER TABLE adresse ALTER COLUMN ort VARCHAR(255) NOT NULL');
	}

}
