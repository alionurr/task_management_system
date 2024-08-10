<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * sail artisan db:seed --class=UserSeeder
     * komutu ile seeder çalışır.
     */
    public function run(): void
    {
        User::factory()->count(10)->create();
    }
}
