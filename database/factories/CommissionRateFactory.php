<?php
namespace Database\Factories;

use App\Models\CommissionRate;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommissionRateFactory extends Factory
{
    protected $model = CommissionRate::class;

    public function definition(): array
    {
        return [
            'employee_id' => Employee::factory(),
            'name' => fake()->word(),
            'rate' => fake()->randomFloat(2, 1, 20),
        ];
    }
}
