<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ErstelleAdresseTabelle extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('adresse', function($table)
        {
            $table->bigIncrements('id');
            $table->string('strasse');
            $table->integer('hausnummer');
            $table->string('zusatz')->nullable();
            $table->string('postleitzahl');
            $table->string('ort');
        });

        Schema::table('person', function($table)
        {
            $table->bigInteger('adresse_id')->unsigned()->nullable();
            $table->foreign('adresse_id')
                ->references('id')
                ->on('adresse');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('person', function($table)
        {
            $table->dropColumn('adresse_id');
        });

        Schema::dropIfExists('adresse');
	}

}
