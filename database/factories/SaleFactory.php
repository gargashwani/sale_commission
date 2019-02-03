<?php

use Faker\Generator as Faker;

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


$factory->define(App\Sale::class, function (Faker $faker) {
    return [
        'employee_id' => $faker->numberBetween($min = 1, $max = 5),
        'saletype_id' => $faker->numberBetween($min = 1, $max = 10),
        'jobnumber' => $faker->unique()->randomNumber($nbDigits = NULL, $strict = false),
        'dateofsale' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = 'now', $timezone = null),
        // 'dateofsale' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'amount' => $faker->numberBetween($min = 100, $max = 10000),
        'commission' => $faker->numberBetween($min = 3, $max = 300),
    ];
});
