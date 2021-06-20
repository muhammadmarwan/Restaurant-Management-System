<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('user_permissions')->insert([
            [
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'user_role' => 1,
                'user_management' => 'on',
                'product_management' => 'on',
                'sales' => 'on',
                'chart_of_accounts' => 'on',
                'vendor_management' => 'on',
                'purchase' => 'on',
                'payment' => 'on',
                'ledger' => 'on',
                'journal' => 'on',
                'trial_balance' => 'on',
                'profit_and_loss' => 'on',
                'petty_cash' => 'on',
                'bank_payment' => 'on',
                'balance_sheet' => 'on',
                'bank_reconciliation' => 'on',
                'payroll' => 'on',
                'stock' => 'on',
                'restaurant_setup' => 'on',

            ], [
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'user_role' => 2,
                'user_management' => 'off',
                'product_management' => 'on',
                'sales' => 'off',
                'chart_of_accounts' => 'on',
                'vendor_management' => 'on',
                'purchase' => 'on',
                'payment' => 'on',
                'ledger' => 'on',
                'journal' => 'on',
                'trial_balance' => 'on',
                'profit_and_loss' => 'on',
                'petty_cash' => 'on',
                'bank_payment' => 'on',
                'balance_sheet' => 'on',
                'bank_reconciliation' => 'on',
                'payroll' => 'on',
                'stock' => 'on',
                'restaurant_setup' => 'on',
            ], [
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'user_role' => 3    ,
                'user_management' => 'on',
                'product_management' => 'on',
                'sales' => 'on',
                'chart_of_accounts' => 'off',
                'vendor_management' => 'off',
                'purchase' => 'off',
                'payment' => 'off',
                'ledger' => 'off',
                'journal' => 'off',
                'trial_balance' => 'off',
                'profit_and_loss' => 'off',
                'petty_cash' => 'off',
                'bank_payment' => 'off',
                'balance_sheet' => 'off',
                'bank_reconciliation' => 'off',
                'payroll' => 'off',
                'stock' => 'off',
                'restaurant_setup' => 'off',
            ],
        ]);
    }
}
