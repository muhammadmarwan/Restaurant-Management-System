<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items_carts', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->string('item_id');
            $table->string('quantity')->default(1);
            $table->string('price');
            $table->string('total_price');
            $table->string('user_id');
            $table->string('bill_no')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('paid_amount')->nullable();
            $table->string('sale_type')->nullable();
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
        Schema::dropIfExists('items_carts');
    }
}
