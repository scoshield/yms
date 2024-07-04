<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApprovalCollumnsToAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dateTime('hod_approved_at')->nullable();
            $table->unsignedBigInteger('hod_approved_by')->nullable();
            $table->dateTime('security_approved_at')->nullable();
            $table->unsignedBigInteger('security_approved_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['hod_approved_at', 'hod_approved_by', 'security_approved_at', 'security_approved_by']);
        });
    }
}
