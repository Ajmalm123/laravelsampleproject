<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'fname'=>$this->faker->name(),
            'lname'=>$this->faker->name(),
            'company_id'=>rand(1,26),
            'email'=>$this->faker->email(),
            'phone'=>$this->faker->phoneNumber()

        ];
    }
}
