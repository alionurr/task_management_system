<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'status', 'project_id', 'user_id'
    ];

    // Görevin ait olduğu proje
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Görevi gerçekleştiren kullanıcı
    public function users()
    {
        return $this->belongsToMany(User::class, 'task_user');
    }
}
