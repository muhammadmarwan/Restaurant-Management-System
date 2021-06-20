<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id');
            $table->string('user_role');
            $table->string('user_management')->default('off');
            $table->string('product_management')->default('off');
            $table->string('sales')->default('off');
            $table->string('chart_of_accounts')->default('off');
            $table->string('vendor_management')->default('off');
            $table->string('purchase')->default('off');
            $table->string('payment')->default('off');
            $table->string('ledger')->default('off');
            $table->string('journal')->default('off');
            $table->string('trial_balance')->default('off');
            $table->string('profit_and_loss')->default('off');
            $table->string('balance_sheet')->default('off');
            $table->string('petty_cash')->default('off');
            $table->string('bank_payment')->default('off');

            $table->string('bank_reconciliation')->default('off');
            $table->string('payroll')->default('off');
            $table->string('stock')->default('off');
            $table->string('restaurant_setup')->default('off');

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
        Schema::dropIfExists('user_permissions');
    }
}
