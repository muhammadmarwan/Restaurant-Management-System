<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AccountSetupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('setup_accounts')->insert([
            [
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'account_type' => 'Cash',
                'bank_status' => 0,

            ], [
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'account_type' => 'Card',
                'bank_status' => 0,

            ],[
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'account_type' => 'Cheque',
                'bank_status' => 0,

            ],[
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'account_type' => 'Bank1',
                'bank_status' => 1,
            ],[
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'account_type' => 'Bank2',
                'bank_status' => 1,

            ],[
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'account_type' => 'Bank3',
                'bank_status' => 1,
            ]
        ]);
    }
}
