<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LoescheSuchgebietHatKoordinateTabelle extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::dropIfExists('suchgebiet_hat_koordinate');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
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
}
