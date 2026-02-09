<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Propiedad;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ROL_INQUILINO   = 'inquilino';
    const ROL_ARRENDADOR  = 'arrendador';
    const ROL_ADMIN       = 'admin';

    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
        'profile_photo',
        'created_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function favoritos()
    {
        return $this->belongsToMany(
            Propiedad::class,
            'favoritos',
            'user_id',
            'propiedad_id'
        );
    }
}