<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(5), // Görev başlığı olarak 5 kelimelik bir cümle
            'description' => $this->faker->paragraph, // Görev açıklaması olarak bir paragraf
            'status' => $this->faker->randomElement(['pending', 'in_progress', 'completed']), // Görev durumu
            'project_id' => Project::factory(), // Görevin ait olduğu proje
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
