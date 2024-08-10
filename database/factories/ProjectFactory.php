<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3), // Proje ismi olarak 3 kelimelik bir cümle
            'description' => $this->faker->paragraph, // Proje açıklaması olarak bir paragraf
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
