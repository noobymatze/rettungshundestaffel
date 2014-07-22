<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ErstelleTerminTabelle extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('termin', function($table)
        {
            $table->bigIncrements('id');
            $table->date('datum');
            $table->enum('art', array('Allgemein', 'Training'));
            $table->string('beschreibung')->nullable();
            $table->bigInteger('adresse_id')->unsigned()->nullable();
            $table->bigInteger('suchgebiet_id')->unsigned()->nullable();
            $table->bigInteger('mitglied_id')->unsigned();
            $table->date('created_at');
            $table->date('updated_at');
            $table->boolean('aktiv');
            $table->date('abgesagt_am');

            $table->foreign('adresse_id')
                ->references('id')
                ->on('adresse');

            $table->foreign('suchgebiet_id')
                ->references('id')
                ->on('suchgebiet');

            $table->foreign('mitglied_id')
                ->references('id')
                ->on('mitglied');
        });

        Schema::create('mitglied_hat_termin', function($table) 
        {
            $table->bigInteger('mitglied_id')->unsigned();
            $table->bigInteger('termin_id')->unsigned();
            $table->enum('status', array('Zugesagt', 'Abgesagt'));
            $table->date('status_geandert_am')->nullable();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::dropIfExists('mitglied_hat_termin');
        Schema::dropIfExists('termin');
	}

}
