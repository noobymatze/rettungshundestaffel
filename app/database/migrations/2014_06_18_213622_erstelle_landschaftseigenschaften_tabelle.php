<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ErstelleLandschaftseigenschaftenTabelle extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('landschaftseigenschaft', function($table) 
        {
            $table->bigIncrements('id');
            $table->string('name');
        });

        Schema::create('suchgebiet_hat_landschaftseigenschaft', function($table) 
        {
            $table->bigInteger('suchgebiet_id')->unsigned();
            $table->bigInteger('landschaftseigenschaft_id')->unsigned();

            $table->foreign('suchgebiet_id')
                ->references('id')
                ->on('suchgebiet');

            $table->foreign('landschaftseigenschaft_id', 'suchgebiet_landschaftseigenschaft')
                ->references('id')
                ->on('landschaftseigenschaft');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::dropIfExists('suchgebiet_hat_landschaftseigenschaft');
        Schema::dropIfExists('landschaftseigenschaft');
	}

}
