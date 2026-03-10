<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SystemConfiguration>
 */
class SystemConfigurationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'festival_name' => fake()->words(3, true).' Festival',
            'registration_start_date' => now()->subDays(10),
            'registration_end_date' => now()->addDays(30),
            'logo_path' => null,
            'primary_color' => fake()->hexColor(),
            'secondary_color' => fake()->hexColor(),
            'tertiary_color' => fake()->hexColor(),
            'text_color' => fake()->hexColor(),
            'button_color' => fake()->hexColor(),
            'button_text_color' => fake()->hexColor(),
            'allow_edit_after_submit' => fake()->boolean(),
        ];
    }

    public function closedPast(): static
    {
        return $this->state(fn (array $attributes) => [
            'registration_start_date' => now()->subDays(20),
            'registration_end_date' => now()->subDays(10),
        ]);
    }

    public function closedFuture(): static
    {
        return $this->state(fn (array $attributes) => [
            'registration_start_date' => now()->addDays(10),
            'registration_end_date' => now()->addDays(20),
        ]);
    }
}
