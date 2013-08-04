<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddVimeoToAssetsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('assets', function(Blueprint $table) {
			$table->integer('vimeo_id');
			$table->string('vimeo_title');
			$table->string('vimeo_url');
			$table->string('vimeo_thumbnail');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('assets', function(Blueprint $table) {
			$table->dropColumn('vimeo_id');
			$table->dropColumn('vimeo_title');
			$table->dropColumn('vimeo_url');
			$table->dropColumn('vimeo_thumbnail');
		});
	}

}
