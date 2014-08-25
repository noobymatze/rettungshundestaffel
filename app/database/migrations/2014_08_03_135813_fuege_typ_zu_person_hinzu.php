<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FuegeTypZuPersonHinzu extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('person', function($table) 
        {
            $table->enum('typ', ['Ansprechpartner', 'Tierarzt', 'Foerster']);
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
            $table->dropColum('typ');
        });
	}

}
