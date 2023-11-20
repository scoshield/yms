<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGatePassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gate_passes', function (Blueprint $table) {
            $table->id();
            $table->string('ref');
            $table->unsignedInteger('appointment_id');
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('print_request_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('appointment_id')->references('id')->on('appointments');
            $table->foreign('created_by')->references('id')->on('users');
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->boolean('gate_pass_printed')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gate_passes');
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('gate_pass_printed');
        });
    }
}
