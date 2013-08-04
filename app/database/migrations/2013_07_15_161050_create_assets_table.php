<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAssetsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function(Blueprint $table) {
            $table->increments('id');
            $table->tinyinteger('active');
			$table->integer('order');
			$table->string('filetype');
			$table->integer('filesize');
			$table->string('path');
			$table->integer('width');
			$table->integer('height');
			$table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('assets');
    }

}
