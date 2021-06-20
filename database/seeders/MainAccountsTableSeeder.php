<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MainAccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('main_accounts')->insert([
            [
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'account_name' => 'Assets',
                'account_id' => 1001,
                'account_type' => null,
                'account_code' => 11212,
            ], [
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'account_name' => 'Liability',
                'account_id' => 1002,
                'account_type' => null,
                'account_code' => 11213,
            ],[
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'account_name' => 'Income',
                'account_id' => 1003,
                'account_type' => null,
                'account_code' => 11214,
            ],[
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'account_name' => 'Expenditure',
                'account_id' => 1004,
                'account_type' => null,
                'account_code' => 11215,
            ],[
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'account_name' => 'Equity',
                'account_id' => 1005,
                'account_type' => null,
                'account_code' => 11216,
            ]
        ]);
    }
}
