<?php
namespace Database\Seeders;

use App\Models\Saletype;
use Illuminate\Database\Seeder;

class SaletypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Saletype::factory(10)->create();
    }
}
