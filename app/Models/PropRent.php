<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropRent extends Model
{
    use HasFactory;

    protected $table = 'prop_ren';

    protected $fillable = [
        'propiedad_id',
        'fecha_renta',
        
    ];
}

?>