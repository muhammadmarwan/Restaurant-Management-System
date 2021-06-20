<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductUnitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('product_quantity_units')->insert([
            [
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'unit' => 'KG',
                'type' => 'Kilo Gram',
            ], [
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'unit' => 'G',
                'type' => 'Gram',
            ], [
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'unit' => 'L',
                'type' => 'Liter',
            ], [
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'unit' => 'ML',
                'type' => 'Milliliter',
            ], [
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'unit' => 'PCS',
                'type' => 'NO OF PIECE',
            ], [
                'transaction_id' => \App\TransactionId\Transaction::setTransactionId(),
                'unit' => 'BOX',
                'type' => 'NO OF BOXES',
            ],
        ]);
    }
}
