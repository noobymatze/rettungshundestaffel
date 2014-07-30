<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TerminAbgesagtAmNullable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement('ALTER TABLE `termin` ALTER `abgesagt_am` DROP DEFAULT;');
		DB::statement('ALTER TABLE `termin` CHANGE COLUMN `abgesagt_am` `abgesagt_am` DATETIME NULL AFTER `aktiv`;');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement('ALTER TABLE `termin` ALTER `abgesagt_am` DROP DEFAULT;');
		DB::statement('ALTER TABLE `termin` CHANGE COLUMN `abgesagt_am` `abgesagt_am` DATETIME NOT NULL AFTER `aktiv`;');
	}

}
