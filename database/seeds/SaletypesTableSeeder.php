<?php

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
        factory(App\Saletype::class, 10)->create();
    }
}
