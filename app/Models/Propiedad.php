<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Propiedad extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'titulo',
        'tipo_prop',
        'barrio',
        'calle',
        'numero_calle',
        'precio',
        'forma_pago',
        'servicio',
        'reglas',
        'cercanias',
        'descripcion',
        'imagen',
        'user_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'precio' => 'decimal:2',
        ];
    }

    public function reviews()
{
    return $this->hasMany(Review::class);
}

public function favoritos()
{
    return $this->belongsToMany(User::class, 'favoritos', 'propiedad_id', 'user_id');
}


}