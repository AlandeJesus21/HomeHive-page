<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Propiedad;
use App\Models\User;

class FavoritoController extends Controller
{
    public function toggle($id)
    {
        $user = Auth::user();

        // Verifica si ya existe como favorito
        $existe = $user->favoritos()->where('propiedad_id', $id)->exists();

        if ($existe) {
            // Eliminar de favoritos
            $user->favoritos()->detach($id);
        } else {
            // Agregar a favoritos
            $user->favoritos()->attach($id);
        }

        return back()->with('success', 'Favorito actualizado');
    }
}