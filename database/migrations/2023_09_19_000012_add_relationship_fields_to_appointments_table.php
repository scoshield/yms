<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToAppointmentsTable extends Migration
{
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            // $table->unsignedInteger('client_id');
            // $table->foreign('client_id', 'client_fk_360714')->references('id')->on('clients');
            // $table->unsignedInteger('employee_id')->nullable();
            // $table->foreign('employee_id', 'employee_fk_360715')->references('id')->on('employees');

            $table->foreign('creator_id')->references('id')->on('users');
            $table->foreign('yard_id')->references('id')->on('yards');
            $table->foreign('hauler_id')->references('id')->on('haulers');
        });
    }

   public function down(){
        #<table_name>_<foreign_table_name>_<column_name>_foreign
        //Schema::disableForeignKeyConstraints();
        // Schema::dropForeign('appointments_creator_id_foreign');
        // Schema::dropForeign('appointments_yard_id_foreign');
        // Schema::dropForeign('appointments_hauler_id_foreign');
    }
}
