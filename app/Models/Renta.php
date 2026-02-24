<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Renta extends Model
{
    protected $fillable = [
        'propiedad_id', 
        'user_id', 
        'arrendador_id', 
        'monto', 
        'fecha_inicio', 
        'fecha_fin', 
        'stripe_id'
    ];

    // Relación para ver los datos de la propiedad en la vista de rentas
    public function propiedad()
    {
        return $this->belongsTo(Propiedad::class, 'propiedad_id');
    }
}