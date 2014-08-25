<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumnAnsprechpartnerFromTableSuchgebiet extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('suchgebiet', function($table)
		{
			$table->dropForeign('suchgebiet_ansprechpartner_foreign');
		    $table->dropColumn(array('ansprechpartner'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('suchgebiet', function($table)
		{
		    $table->bigInteger('ansprechpartner')->unsigned()->nullable();

			$table->foreign('ansprechpartner')
                ->references('id')
                ->on('mitglied');
		});
	}

}
