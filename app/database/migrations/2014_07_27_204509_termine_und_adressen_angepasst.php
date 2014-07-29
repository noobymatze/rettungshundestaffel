<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TermineUndAdressenAngepasst extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('termin', function($tabelle)
		{
			$tabelle->dropColumn('datum');
			$tabelle->dropColumn('created_at');
			$tabelle->dropColumn('updated_at');
			$tabelle->dropColumn('abgesagt_am');
		});
		
		Schema::table('termin', function($tabelle)
		{
			$tabelle->datetime('datum');
			$tabelle->datetime('created_at');
			$tabelle->datetime('updated_at');
			$tabelle->datetime('abgesagt_am');
		});
		
		

		Schema::table(('adresse'), function($tabelle)
		{
			$tabelle->dropColumn('strasse');
			$tabelle->dropColumn('hausnummer');
			$tabelle->dropColumn('postleitzahl');
		});
		
		Schema::table(('adresse'), function($tabelle)
		{
			$tabelle->string('strasse')->nullable();
			$tabelle->integer('hausnummer')->nullable();
			$tabelle->string('postleitzahl')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('termin', function($tabelle)
		{
			$tabelle->dropColumn('datum');
			$tabelle->dropColumn('created_at');
			$tabelle->dropColumn('updated_at');
			$tabelle->dropColumn('abgesagt_am');
		});
		
		Schema::table('termin', function($tabelle)
		{
			$tabelle->date('datum');
			$tabelle->date('created_at');
			$tabelle->date('updated_at');
			$tabelle->date('abgesagt_am');
		});

		Schema::table(('adresse'), function($tabelle)
		{
			$tabelle->dropColumn('strasse');
			$tabelle->dropColumn('hausnummer');
			$tabelle->dropColumn('postleitzahl');
		});
		Schema::table(('adresse'), function($tabelle)
		{
			$tabelle->string('strasse');
			$tabelle->integer('hausnummer');
			$tabelle->string('postleitzahl');
		});
	}

}
