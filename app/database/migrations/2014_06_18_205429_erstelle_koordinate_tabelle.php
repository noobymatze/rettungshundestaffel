<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ErstelleKoordinateTabelle extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('koordinate', function($table)
        {
            $table->bigIncrements('id');
            $table->double('laengengrad', 15, 8);
            $table->double('breitengrad', 15, 8);
        });

        Schema::table('suchgebiet', function($table) 
        {
            $table->bigInteger('treffpunkt')->unsigned();
            $table->foreign('treffpunkt')
                ->references('id')
                ->on('koordinate');
        });

        Schema::create('suchgebiet_hat_koordinaten', function($table)
        {
            $table->bigInteger('koordinate_id')->unsigned();
            $table->bigInteger('suchgebiet_id')->unsigned();
            $table->foreign('koordinate_id')
                ->references('id')
                ->on('koordinate');

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
        Schema::dropIfExists('suchgebiet_hat_koordinaten');
        Schema::table('suchgebiet', function($table) 
        {
            $table->dropColumn('treffpunkt');
        });

        Schema::dropIfExists('koordinate');
	}

}
