<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ErstelleSuchart extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('suchart', function($table)
        {
            $table->bigIncrements('id');
            $table->string('name');
        });

        Schema::create('hund_hat_suchart', function($table) 
        {
            $table->bigInteger('hund_id')->unsigned();
            $table->bigInteger('suchart_id')->unsigned();
            $table->boolean('geprueft');
            $table->date('geprueft_am')->nullable();
            $table->date('geprueft_bis')->nullable();

            $table->primary(array('hund_id', 'suchart_id'));
            $table->foreign('hund_id')
                ->references('id')
                ->on('hund');

            $table->foreign('suchart_id')
                ->references('id')
                ->on('suchart');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::dropIfExists('hund_hat_suchart');
        Schema::dropIfExists('suchart');
	}

}
