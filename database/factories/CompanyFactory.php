<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->company();
        return [
            'user_id'=> \App\Models\User::factory(),
            'name'=>$name,
            'slug'=>\Illuminate\Support\Str::slug($name). '_'. fake()->unique()->numberBetween(1, 9999),
            'description'=>fake()->paragraph(),
            'city'=>fake()->randomElement(['Hồ Chí Mình', 'Hà Nội', 'Đà Nẵng']),
        ];
    }
}
