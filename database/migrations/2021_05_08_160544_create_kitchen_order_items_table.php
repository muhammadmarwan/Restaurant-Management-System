<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKitchenOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kitchen_order_items', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id');
            $table->string('kitchen_order_id');
            $table->string('order_type');
            $table->string('token_no');
            $table->string('item_name');
            $table->string('item_code');
            $table->string('quantity');
            $table->string('table_no')->nullable();
            $table->string('status')->default(0);
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
        Schema::dropIfExists('kitchen_order_items');
    }
}
