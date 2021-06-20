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
            $table->id();
            $table->string('transaction_id');
            $table->string('product_category_code');
            $table->string('product_name');
            $table->string('product_code');
            $table->string('brand');
            $table->string('barcode')->nullable();
            $table->string('barcode_status')->nullable();
            $table->string('quantity_unit');
            $table->string('stock')->default(0);
            $table->string('selling_price')->default(0);
            $table->string('narration')->nullable();
            $table->string('created_by');
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('products');
    }
}
