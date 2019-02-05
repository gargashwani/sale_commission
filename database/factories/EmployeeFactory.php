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

// User Roles
// 1 => Admin
// 2 => Manager
// 3 => Employees

$factory->define(App\Employee::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'status' => '1',
        'city' => $faker->city,
        'state' => $faker->state,
        'address' => $faker->streetAddress,
        'zip' => $faker->postcode,
        'phone' => $faker->e164PhoneNumber,
        'bgcolor' => $faker->hexcolor,
        'bordercolor' => $faker->hexcolor,
    ];
});
