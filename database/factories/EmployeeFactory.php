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

// User Roles
// 1 => Admin
// 2 => Manager
// 3 => Employees

class EmployeeFactory extends Factory{
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'email' => fake()->unique()->safeEmail,
            'status' => '1',
            'city' => fake()->city,
            'state' => fake()->state,
            'address' => fake()->streetAddress,
            'zip' => fake()->postcode,
            'phone' => fake()->phoneNumber,
            'bgcolor' => fake()->hexcolor,
            'bordercolor' => fake()->hexcolor,
        ];
    }

}
