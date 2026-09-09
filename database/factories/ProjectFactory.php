<?php

namespace Database\Factories;

use App\Enums\ProjectStatus;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        $title = fake()->sentence(3);

        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . fake()->unique()->numberBetween(100, 999),
            'category' => fake()->randomElement(['Commercial', 'Industrial', 'Civic', 'Residential', 'Infrastructure']),
            'client_name' => fake()->company(),
            'location' => fake()->city() . ', ' . fake()->stateAbbr(),
            'start_date' => now()->subMonths(fake()->numberBetween(2, 24)),
            'completion_date' => now()->addMonths(fake()->numberBetween(1, 18)),
            'status' => fake()->randomElement(ProjectStatus::cases()),
            'short_description' => fake()->paragraph(2),
            'description' => fake()->paragraphs(3, true),
            'featured' => fake()->boolean(25),
            'sort_order' => fake()->numberBetween(0, 50),
            'is_published' => true,
            'meta_title' => $title,
            'meta_description' => fake()->sentence(10),
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

    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'featured' => true,
        ]);
    }
}
