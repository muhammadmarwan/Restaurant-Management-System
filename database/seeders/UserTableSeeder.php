<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\TransactionId\Transaction;
use App\Common\UserRole;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('users')->insert([
            [
                'transaction_id' => Transaction::setTransactionId(),
                'user_id' => 'admin01',
                'user_name' => 'admin01',
                'user_role' => UserRole::Admin,
                'email_id' => 'admin01@teenets.com',
                'phone_number' => +971568382638,
                'password' => bcrypt('12345')
   
            ]
        ]);
    }
}
