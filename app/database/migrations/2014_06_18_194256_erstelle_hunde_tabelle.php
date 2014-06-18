<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ErstelleHundeTabelle extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('hund', function(Blueprint $table)
		{
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('rasse')->nullable();
            $table->integer('alter')->nullable();
            $table->bigInteger('mitglied_id')->unsigned();

            $table->foreign('mitglied_id')
                ->references('id')
                ->on('mitglied')
                ->onDelete('cascade');
		});

        DB::statement('ALTER TABLE hund ADD bild LONGBLOB');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::dropIfExists('hund');
	}

}
