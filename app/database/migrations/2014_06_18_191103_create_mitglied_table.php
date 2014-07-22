<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMitgliedTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('mitglied', function ($table) 
        {
            $table->bigIncrements('id');
            $table->string('vorname')->nullable();
            $table->string('nachname')->nullable();
            $table->string('email');
            $table->string('passwort');
            $table->string('telefon')->nullable();
            $table->string('mobil')->nullable();
            $table->enum('rolle', array('Mitglied', 'Staffelleitung'));
        });

        // LONGBlob wird nicht von Laravel unterstützt,
        // deswegen manuell:
        DB::statement('ALTER TABLE mitglied ADD profilbild LONGBLOB');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::dropIfExists('mitglied');
	}

}
