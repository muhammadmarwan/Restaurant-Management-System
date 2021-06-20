<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(MainAccountsTableSeeder::class);
        $this->call(AccountSetupTableSeeder::class);
        $this->call(UserRoleSeeder::class); 
        $this->call(CountryTableSeeder::class); 
        $this->call(SalarySetupTableSeeder::class);
        $this->call(UserPermissionTableSeeder::class); 
        $this->call(SubAccountsTableSeeder::class);

        $this->call(ProductUnitTableSeeder::class); 

        $this->call(ItemsSetupTableSeeder::class);         
    }
}
