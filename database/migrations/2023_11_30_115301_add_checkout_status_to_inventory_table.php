<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCheckoutStatusToInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventory_items', function (Blueprint $table) {
            $table->boolean('checked_out')->default(false);
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->unsignedInteger('checking_out_inventory_item_id')->nullable();
            $table->foreign('checking_out_inventory_item_id')->references('id')->on('inventory_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventory_items', function (Blueprint $table) {
            $table->dropColumn('checked_out');
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('checking_out_inventory_item_id');
        });
    }
}
