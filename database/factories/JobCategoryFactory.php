<?php

namespace Database\Factories;

use App\Models\JobCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<JobCategory>
 */
class JobCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'IT Phần Mềm', 'Kinh doanh', 'Marketing', 'Kế toán', 'Nhân sự', 'Thiết kế', 'Chăm sóc khách hàng', 'Logistics',
        ]);
        return [
            'name'=>$name,
            'slug'=>\Illuminate\Support\Str::slug($name),
        ];
    }
}
