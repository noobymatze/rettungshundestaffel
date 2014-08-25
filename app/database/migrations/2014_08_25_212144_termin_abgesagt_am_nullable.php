<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TerminAbgesagtAmNullable2 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('termin', function($table)
		{
			$table->dropColumn('abgesagt_am');
		});
		
		Schema::table('termin', function($table)
		{
			$table->datetime('abgesagt_am')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('termin', function($table)
		{
			$table->dropColumn('abgesagt_am');
		});
		
		Schema::table('termin', function($table)
		{
			$table->datetime('abgesagt_am');
		});
	}

}
