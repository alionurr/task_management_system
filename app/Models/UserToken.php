<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserToken extends Model
{
    protected $fillable = [
        'user_id', 'token', 'expires_at', 'is_revoked'
    ];

    // Token'ın ait olduğu kullanıcı
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
