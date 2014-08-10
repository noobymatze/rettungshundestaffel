<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetzePkInTabelleSuchgebietHatLandschaftseigenschaften extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('suchgebiet_hat_landschaftseigenschaft', function($table)
		{
		    $table->renameColumn('landschaftseigenschaft_id', 'eigenschaft_id');
		});

		Schema::rename('suchgebiet_hat_landschaftseigenschaft', 'suchgebiet_eigenschaft');
		Schema::rename('landschaftseigenschaft', 'eigenschaft');

		Schema::table('suchgebiet_eigenschaft', function($table)
		{
			$table->primary(array('suchgebiet_id', 'eigenschaft_id'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('suchgebiet_eigenschaft', function($table)
		{
			$table->dropPrimary(array('suchgebiet_id', 'eigenschaft_id'));
		});

		Schema::rename('suchgebiet_eigenschaft', 'suchgebiet_hat_landschaftseigenschaft');
		Schema::rename('eigenschaft', 'landschaftseigenschaft');

		Schema::table('suchgebiet_hat_landschaftseigenschaft', function($table)
		{
		    $table->renameColumn('eigenschaft_id', 'landschaftseigenschaft_id');
		});
	}

}
