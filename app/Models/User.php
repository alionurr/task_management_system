<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory;

    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    // Kullanıcının sahip olduğu projeler
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_user');
    }

    // Kullanıcının sahip olduğu token
    public function token()
    {
        return $this->hasOne(UserToken::class);
    }

    // Kullanıcının görevleri (eğer görev atamaları mevcutsa)
    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_user');
    }
}
