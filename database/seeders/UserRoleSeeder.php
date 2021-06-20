<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('user_roles')->insert([
            [
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'user_role' => 'Super Admin',
                'user_role_id' => 0,
                'description' => 'He can access everything',
            ], [
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'user_role' => 'Admin',
                'user_role_id' => 1,
                'description' => 'Admin user',
            ], [
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'user_role' => 'Accountant',
                'user_role_id' => 2,
                'description' => 'Accountant user',
            ], [
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'user_role' => 'Cashier',
                'user_role_id' => 3,
                'description' => 'Cashier user',
            ],
        ]);
    }
}
