<?php

namespace Database\Seeders;

use App\Models\Task;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * 
     * Fazla seeder olursa, hepsi burada çağırılıp 
     * 'sail artisan db:seed'
     * komutu ile hepsi birden çalıştırılabilir.
     */
    public function run(): void
    {
        // UserSeeder'ı çalıştır
        // $this->call(UserSeeder::class);
        // $this->call(TaskSeeder::class);
        // $this->call(ProjectSeeder::class);


        // 5 adet kullanıcı oluştur
        $users = User::factory()->create([
            'role' => 'admin',
        ]);
        $users= User::factory()->count(5)->create();

        $projects = Project::factory()->count(3)->create();
        
        // Her proje için 2 kişi ataması yap ve 3 görev oluştur
        $projects->each(function ($project) use ($users) {
            $randomUsers = $users->random(2)->pluck('id');
            $project->users()->attach($randomUsers);

            $tasks = Task::factory()->count(3)->create([
                'project_id' => $project->id,
            ]);

            // Her göreve rastgele 2 kullanıcı ata
            $tasks->each(function ($task) use ($randomUsers) {
                $task->users()->attach($randomUsers);
            });
        });
    }
}
