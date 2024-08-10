<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * sail artisan db:seed --class=TaskSeeder
     * komutu ile seeder çalışır.
     */
    public function run(): void
    {
        Task::factory()->count(15)->create();
    }
}
