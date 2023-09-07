<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category');
            $table->string('ref'); //container or tanktainer number
            $table->string('um_number')->nullable();
            $table->unsignedInteger('yard_id'); // Location
            $table->unsignedInteger('department_id');
            $table->string('rtn_port')->nullable();
            $table->string('size')->nullable();
            $table->string('status')->nullable();
            $table->string('structural_status')->nullable();
            $table->boolean('inspected')->nullable();
            $table->boolean('refurbished')->nullable();
            $table->boolean('cnumbers_visible')->nullable();
            $table->string('year_manufactured', 20)->nullable();
            $table->string('type')->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();
            $table->foreign('yard_id')->references('id')->on('yards')->onDelete('restrict');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
