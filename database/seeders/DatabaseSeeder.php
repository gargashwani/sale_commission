<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\SalesTableSeeder;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\EmployeesTableSeeder;
use Database\Seeders\SaletypesTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(EmployeesTableSeeder::class);
        $this->call(SaletypesTableSeeder::class);
        $this->call(SalesTableSeeder::class);
    }
}
