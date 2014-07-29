<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ErzeugeFlaecheTabelle extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('flaeche', function ($table)
        {
            $table->bigIncrements('id');
            $table->bigInteger('suchgebiet_id')->unsigned();
            
            $table->foreign('suchgebiet_id')
                ->references('id')
                ->on('suchgebiet')
                ->onDelete('cascade');
        });

        // POLYGON wird nicht von Laravel unterstützt,
        // deswegen manuell:
        DB::statement('ALTER TABLE flaeche ADD polygon POLYGON');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('flaeche');
	}
}
