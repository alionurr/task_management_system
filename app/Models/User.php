<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;

    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    protected $hidden = [
        'password',
    ];

    // Kullanıcının sahip olduğu projeler
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    // Kullanıcının sahip olduğu tokenlar
    public function tokens()
    {
        return $this->hasMany(UserToken::class);
    }

    // Kullanıcının görevleri (eğer görev atamaları mevcutsa)
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
