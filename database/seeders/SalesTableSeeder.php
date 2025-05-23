<?php
namespace Database\Seeders;

use App\Models\Sale;
use Illuminate\Database\Seeder;

class SalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sale::factory(10)->create();
    }
}
