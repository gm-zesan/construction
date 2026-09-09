<?php

namespace Database\Factories;

use App\Models\TeamMember;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamMemberFactory extends Factory
{
    protected $model = TeamMember::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'designation' => fake()->jobTitle(),
            'department' => fake()->randomElement(['Architecture & BIM Planning', 'Structural Engineering', 'Construction Operations', 'Executive Board']),
            'bio' => fake()->paragraph(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'linkedin_url' => 'https://linkedin.com',
            'twitter_url' => 'https://x.com',
            'facebook_url' => null,
            'sort_order' => fake()->numberBetween(0, 50),
            'is_active' => true,
            'is_featured' => true,
            'created_by' => null,
            'updated_by' => null,
        ];
    }

    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
