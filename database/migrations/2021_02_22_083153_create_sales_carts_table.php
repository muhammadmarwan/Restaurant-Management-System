<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_carts', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->nullable();
            $table->string('product_name')->nullable();
            $table->integer('product_qty')->nullable();
            $table->string('product_price')->nullable();
            $table->string('price_total')->nullable();
            $table->string('user_id')->nullable();
            $table->string('bill_id')->nullable();
            $table->integer('return_status')->nullable();
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
        Schema::dropIfExists('sales_carts');
    }
}
