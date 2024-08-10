<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * sail artisan db:seed --class=ProjectSeeder
     * komutu ile seeder çalışır.
     */
    public function run(): void
    {
        Project::factory()->count(5)->create();
    }
}
