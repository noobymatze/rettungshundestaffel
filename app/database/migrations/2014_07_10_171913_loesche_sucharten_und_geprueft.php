<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LoescheSuchartenUndGeprueft extends Migration {

    private $suchtypen = ['Flaechensuche','Mantrailing','Truemmersuche','Lawinensuche','Wasserrettung','Wasserortung','Leichensuche'];

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('suchart', function (Blueprint $table) 
        {
            $table->dropColumn('suchtyp');
        });

        DB::table('suchart')->delete();
        foreach($this->suchtypen as $suchtyp) 
        {
            Suchart::create(['name' => $suchtyp]);
        }

        Schema::table('hund_hat_suchart', function (Blueprint $table) 
        {
            $table->dropColumn('geprueft');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('suchart', function(Blueprint $table)
        {
            $table->enum('suchtyp', $this->suchtypen);
        });
	}

}
