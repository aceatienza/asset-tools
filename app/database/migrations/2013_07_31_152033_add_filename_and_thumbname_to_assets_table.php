<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddFilenameAndThumbnameToAssetsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assets', function(Blueprint $table) {
            $table->string('filename');
            $table->string('thumbname');            
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
            $table->string('filename');
            $table->string('thumbname');            
        });
    }

}
