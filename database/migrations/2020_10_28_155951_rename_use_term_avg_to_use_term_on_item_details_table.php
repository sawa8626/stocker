<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameUseTermAvgToUseTermOnItemDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_details', function (Blueprint $table) {
            $table->renameColumn('use_term_avg', 'use_term');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_details', function (Blueprint $table) {
            $table->renameColumn('use_term', 'use_term_avg');
        });
    }
}
