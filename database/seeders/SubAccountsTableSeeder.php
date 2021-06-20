<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SubAccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('sub_accounts')->insert([
            [
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'account_name' => 'Fixed assets',
                'parent_account_id' => 1001,
                'account_code' => 1111,
                'balance_amount' => 0,
                'degree'=>1,
            ],[
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'account_name' => 'Cash',
                'parent_account_id' => 1001,
                'account_code' => 1113,
                'balance_amount' => 0,
                'degree'=>1,
            ],[
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'account_name' => 'Bank',
                'parent_account_id' => 1001,
                'account_code' => 1114,
                'balance_amount' => 0,
                'degree'=>1,
            ],[
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'account_name' => 'Card',
                'parent_account_id' => 1001,
                'account_code' => 1115,
                'balance_amount' => 0,
                'degree'=>1,
            ],[
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'account_name' => 'Inventory Goods',
                'parent_account_id' => 1001,
                'account_code' => 1116,
                'balance_amount' => 0,
                'degree'=>1,
            ],[
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'account_name' => 'Petty Cash',
                'parent_account_id' => 1001,
                'account_code' => 1117,
                'balance_amount' => 0,
                'degree'=>1,
            ],
            [
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'account_name' => 'Sale Cash',
                'parent_account_id' => 1001,
                'account_code' => 1118,
                'balance_amount' => 0,
                'degree'=>1,
            ],[
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'account_name' => 'Sale Card',
                'parent_account_id' => 1001,
                'account_code' => 1119,
                'balance_amount' => 0,
                'degree'=>1,
            ],[
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'account_name' => 'Prepaid Expense RENT',
                'parent_account_id' => 1001,
                'account_code' => 1120,
                'balance_amount' => 0,
                'degree'=>1,
            ],

            [
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'account_name' => 'Other liability',
                'parent_account_id' => 1002,
                'account_code' => 2222,
                'balance_amount' => 0,
                'degree'=>1,
            ],[
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'account_name' => 'Credit Card',
                'parent_account_id' => 1002,
                'account_code' => 2223,
                'balance_amount' => 0,
                'degree'=>1,
            ],[
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'account_name' => 'Long term liability',
                'parent_account_id' => 1002,
                'account_code' => 2224,
                'balance_amount' => 0,
                'degree'=>1,
            ],[
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'account_name' => 'Salary payable',
                'parent_account_id' => 1002,
                'account_code' => 2225,
                'balance_amount' => 0,
                'degree'=>1,
            ],[
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'account_name' => 'Sale Tax',
                'parent_account_id' => 1002,
                'account_code' => 2225,
                'balance_amount' => 0,
                'degree'=>1,
            ],[
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'account_name' => 'Share Capital',
                'parent_account_id' => 1002,
                'account_code' => 2226,
                'balance_amount' => 0,
                'degree'=>1,
            ],[
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'account_name' => 'Input Tax',
                'parent_account_id' => 1002,
                'account_code' => 2227,
                'balance_amount' => 0,
                'degree'=>1,
            ],
           
            [
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'account_name' => 'Income',
                'parent_account_id' => 1003,
                'account_code' => 4444,
                'balance_amount' => 0,
                'degree'=>1,
            ],[
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'account_name' => 'Other Income',
                'parent_account_id' => 1003,
                'account_code' => 4445,
                'balance_amount' => 0,
                'degree'=>1,
            ],[
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'account_name' => 'Sale Revenue',
                'parent_account_id' => 1003,
                'account_code' => 4446,
                'balance_amount' => 0,
                'degree'=>1,
            ],
            
            [
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'account_name' => 'Expenses',
                'parent_account_id' => 1004,
                'account_code' => 5555,
                'balance_amount' => 0,
                'degree'=>1,
            ],[
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'account_name' => 'Other expenses',
                'parent_account_id' => 1004,
                'account_code' => 5550,
                'balance_amount' => 0,
                'degree'=>1,
            ],[
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'account_name' => 'Salary accounts',
                'parent_account_id' => 1004,
                'account_code' => 5556,
                'balance_amount' => 0,
                'degree'=>1,
            ],[
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'account_name' => 'Cost Of Ivnentory Goods',
                'parent_account_id' => 1004,
                'account_code' => 5557,
                'balance_amount' => 0,
                'degree'=>1,
            ],[
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'account_name' => 'Cost Of Ivnentory Beverage',
                'parent_account_id' => 1004,
                'account_code' => 5558,
                'balance_amount' => 0,
                'degree'=>1,
            ],[
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'account_name' => 'Monthly Rent',
                'parent_account_id' => 1004,
                'account_code' => 5559,
                'balance_amount' => 0,
                'degree'=>1,
            ],

            [
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'account_name' => 'Equity',
                'parent_account_id' => 1005,
                'account_code' => 6666,
                'balance_amount' => 0,
                'degree'=>1,
            ],

            //SPECIAL ACCOUNTS
            [
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'account_name' => 'Payable Account',
                'parent_account_id' => 1002,
                'account_code' => 9090,
                'balance_amount' => 0,
                'degree'=>3,
            ], [
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'account_name' => 'Receivable Account',
                'parent_account_id' => 1001,
                'account_code' => 8080,
                'balance_amount' => 0,
                'degree'=>3,
            ],
        ]);

    }
}
