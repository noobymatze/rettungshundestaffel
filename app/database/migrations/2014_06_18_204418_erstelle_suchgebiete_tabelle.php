<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ErstelleSuchgebieteTabelle extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('suchgebiet', function($table) 
        {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('beschreibung');
            $table->date('created_at');
            $table->date('updated_at')->nullable();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::dropIfExists('suchgebiet');
	}

}
