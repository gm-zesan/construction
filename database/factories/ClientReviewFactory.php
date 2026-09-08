<?php

namespace Database\Factories;

use App\Models\ClientReview;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientReviewFactory extends Factory
{
    protected $model = ClientReview::class;

    public function definition(): array
    {
        return [
            'client_name' => fake()->name(),
            'designation' => fake()->jobTitle(),
            'company_name' => fake()->company(),
            'review' => fake()->paragraph(3),
            'rating' => fake()->numberBetween(4, 5),
            'project_id' => null,
            'featured' => fake()->boolean(30),
            'is_published' => true,
            'sort_order' => fake()->numberBetween(0, 50),
            'created_by' => null,
            'updated_by' => null,
        ];
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => true,
        ]);
    }

    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => false,
        ]);
    }

    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'featured' => true,
        ]);
    }
}
