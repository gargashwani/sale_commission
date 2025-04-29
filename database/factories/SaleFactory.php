<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/
class SaleFactory extends Factory{
    public function definition(): array
    {
        return [
            'employee_id' => fake()->numberBetween($min = 1, $max = 5),
            'saletype_id' => fake()->numberBetween($min = 1, $max = 10),
            'jobnumber' => fake()->unique()->randomNumber($nbDigits = NULL, $strict = false),
            'dateofsale' => fake()->dateTimeBetween($startDate = '-2 years', $endDate = 'now', $timezone = null),
            // 'dateofsale' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'amount' => fake()->numberBetween($min = 100, $max = 10000),
            'commission' => fake()->numberBetween($min = 3, $max = 300),
        ];
    }

}
