<?php

namespace Database\Factories;

use App\Models\JobPost;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Company;
use App\Models\JobCategory;
use App\Models\User;


class JobPostFactory extends Factory
{
    
    public function definition(): array
    {
        $min = fake()->numberBetween(8, 30) * 1_000_000;
        return [
            'company_id'=>Company::factory(),
            'category_id'=>JobCategory::inRandomOrder()->first()?->id ?? JobCategory::factory(),
            'created_by'=>User::factory(),
            'title'=>fake()->randomElement([
                'Backend Developer', 'Frontend Developer', 'Fullstack Developer',
                'Business Analyst', 'QA Engineer', 'DevOps Engineer',
                'Product Manager', 'UI/UX Designer',
            ]). '('. fake()->randomElement(['Junior', 'Middle', 'Senior']).')',
            'slug'=>fake()->unique()->slug(),
            'description'=>fake()->paragraphs(3, true),
            'requirements'=>fake()->paragraphs(2, true),
            'benefits'=>fake()->paragraphs(),
            'employment_type'=>fake()->randomElement(['full_time', 'part_time', 'contract', 'internship']),
            'location'=>fake()->randomElement(['Hồ Chí Minh', 'Hà Nội', 'Đà Nẵng', 'Cần Thơ', 'Remote']),
            'salary_min'=>$min,
            'salary_max'=>$min + fake()->numberBetween(5, 20) * 1_000_000,
            'salary_negotiable'=>fake()->boolean(20),
            'status'=>'published',
            'deadline'=>fake()->dateTimeBetween('+1 week', '3 months'),
            'published_at'=>fake()->dateTimeBetween('-2 months', 'now'),
            'views_count'=>fake()->numberBetween(0, 500),
        ];
    }
    public function pendingReview(): static
    {
        return $this->state(fn () => ['status' => 'pending_review', 'published_at' => null]);

    }
    public function expired():static
    {
        return $this->state(fn () =>['deadline' => now()->subDays(5)]);
    }
}
