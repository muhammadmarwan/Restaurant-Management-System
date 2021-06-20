<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rest_sales', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id');
            $table->string('bill_no');
            $table->string('total_amount');
            $table->string('paid_amount')->nullable();
            $table->string('return_cash')->nullable();
            $table->string('sale_type')->nullable();
            $table->string('sale_type_id')->nullable();
            $table->string('table_no')->nullable();
            $table->string('payment_method')->default('cash');
            $table->string('barcode')->nullable();
            $table->string('discount')->default(0);
            $table->string('payment_status')->default(0);
            $table->string('close_status')->default(0);
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
        Schema::dropIfExists('rest_sales');
    }
}
