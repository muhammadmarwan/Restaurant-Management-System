<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SalarySetupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('salary_setups')->insert([
            [
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'account_type' => 'Salary Payable',
            ], [
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'account_type' => 'Salary Receivable',
            ],
        ]);

        \Illuminate\Support\Facades\DB::table('purchase_setups')->insert([
            [
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'account_type' => 'Purchase Tax Account',
            ], 
        ]);
        \Illuminate\Support\Facades\DB::table('cash_drawers')->insert([
            [
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'drawer_cash' => 0,
            ], 
        ]);
    }
}
