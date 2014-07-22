<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ErstellePersonTabelle extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('person', function($table)
        {
            $table->bigIncrements('id');
            $table->string('vorname');
            $table->string('nachname');
            $table->string('telefon')->nullable();
            $table->string('mobil')->nullable();
            $table->bigInteger('suchgebiet_id')->unsigned();
            $table->foreign('suchgebiet_id')
                ->references('id')
                ->on('suchgebiet');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::dropIfExists('person');
	}

}
