<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStartedByColumntToLoadingBayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loading_bay', function (Blueprint $table) {
            $table->unsignedBigInteger('started_by')->nullable()->after('started_at');
            $table->unsignedBigInteger('finished_by')->nullable()->after('finished_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loading_bay', function (Blueprint $table) {
            //
        });
    }
}
