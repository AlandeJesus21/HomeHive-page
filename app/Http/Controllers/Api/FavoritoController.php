<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Propiedad;
use Illuminate\Http\Request;

class FavoritoController extends Controller
{
    /**
     * Agregar o quitar un favorito (toggle)
     */
    public function toggle(Request $request, $id)
    {
        $user = $request->user();

        $propiedad = Propiedad::find($id);

        if (!$propiedad) {
            return response()->json([
                "success" => false,
                "message" => "Propiedad no encontrada"
            ], 404);
        }

        // Verificar si ya existe en favoritos
        $yaEsFavorito = $user->favoritos()->where('propiedad_id', $id)->exists();

        if ($yaEsFavorito) {
            $user->favoritos()->detach($id);

            return response()->json([
                "success" => true,
                "message" => "Propiedad eliminada de favoritos"
            ], 200);
        }

        // Si no es favorito, agregar
        $user->favoritos()->attach($id);

        return response()->json([
            "success" => true,
            "message" => "Propiedad agregada a favoritos"
        ], 201);
    }

    /**
     * Listar favoritos del usuario autenticado
     */
    public function index(Request $request)
    {
        $user = $request->user();

        return response()->json([
            "success" => true,
            "data" => [
                "favoritos" => $user->favoritos()->get()
            ]
        ], 200);
    }

    /**
     * Eliminar un favorito directamente
     */
    public function eliminar(Request $request, $id)
    {
        $user = $request->user();

        $user->favoritos()->detach($id);

        return response()->json([
            "success" => true,
            "message" => "Favorito eliminado correctamente"
        ], 200);
    }
}