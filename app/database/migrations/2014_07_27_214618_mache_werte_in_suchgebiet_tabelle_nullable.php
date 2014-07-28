<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MacheWerteInSuchgebietTabelleNullable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('suchgebiet', function($table)
		{
			$table->dropForeign('suchgebiet_treffpunkt_foreign');
		    $table->dropColumn(array('beschreibung', 'treffpunkt'));
		});

		Schema::table('suchgebiet', function(Blueprint $table)
		{
			$table->string('beschreibung')->nullable();
			$table->bigInteger('treffpunkt')->unsigned()->nullable();

			$table->foreign('treffpunkt')
                ->references('id')
                ->on('koordinate');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement('ALTER TABLE suchgebiet ALTER COLUMN beschreibung VARCHAR(255) NOT NULL');
		DB::statement('ALTER TABLE suchgebiet ALTER COLUMN treffpunkt BIGINT(20) NOT NULL');
		Schema::table('suchgebiet', function(Blueprint $table)
		{
			$table->foreign('treffpunkt')
                ->references('id')
                ->on('koordinate');
		});
	}

}
