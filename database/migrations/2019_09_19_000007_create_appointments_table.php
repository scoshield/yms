<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('start_time');
            $table->datetime('finish_time');

            $table->string('purpose');
            $table->unsignedInteger('yard_id');
            $table->unsignedInteger('hauler_id')->nullable();
            $table->unsignedInteger('creator_id');
            
            $table->string('truck_details');
            $table->string('driver_name');
            $table->string('contact_details');
            $table->string('file_number')->nullable();
            $table->string('container_number')->nullable();
            $table->string('status')->default('pending');

            $table->longText('comments')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
