<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePortfoliosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if( !Schema::hasTable('portfolios') ) {
			Schema::create('portfolios', function(Blueprint $table) {
				$table->increments('id');
				$table->string('client_name');
				$table->string('description');
				$table->date('date');
				$table->integer('portfolio_category_id');
				$table->integer('phase_id');
				$table->timestamps();
			});
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('portfolios');
	}

}
