<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Propiedad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewApiController extends Controller
{
    // Obtener todas las reseñas de una propiedad
    public function index($idPropiedad)
    {
        $propiedad = Propiedad::with('propiedad');

        if (!$propiedad) {
            return response()->json(['error' => 'Propiedad no encontrada'], 404);
        }elseif(isset($Propiedad)){
         return response()->json(['error' => 'La propiedad no tiene reseñas'], 400);
        }


        $reviews = Review::where('propiedad_id', $idPropiedad)
            ->with('usuario')
            ->get();

        return response()->json($reviews);
    }

    // Mostrar solo una reseña
    public function show($id)
    {
        $review = Review::with('user:id,name')->find($id);

        if (!$review) {
            return response()->json(['error' => 'Reseña no encontrada'], 404);
        }

        return response()->json($review);
    }

    // Crear una nueva reseña
    public function store(Request $request, $idPropiedad)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:500'
        ]);

        $propiedad = Propiedad::find($idPropiedad);

        if (!$propiedad) {
            return response()->json(['error' => 'Propiedad no encontrada'], 404);
        }

        $review = Review::create([
            'propiedad_id' => $idPropiedad,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comentario' => $request->comentario
        ]);

        return response()->json([
            'message' => 'Reseña creada correctamente',
            'data' => $review
        ], 201);
    }

    // Actualizar una reseña
    public function update(Request $request, $id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json(['error' => 'Reseña no encontrada'], 404);
        }

        // Verificar que el usuario sea el dueño
        if ($review->user_id !== Auth::id()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $request->validate([
            'rating' => 'integer|min:1|max:5',
            'comentario' => 'nullable|string|max:500'
        ]);

        $review->update($request->only(['rating', 'comentario']));

        return response()->json([
            'message' => 'Reseña actualizada',
            'data' => $review
        ]);
    }

    // Eliminar reseña
    public function destroy($id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json(['error' => 'Reseña no encontrada'], 404);
        }

        if ($review->user_id !== Auth::id()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $review->delete();

        return response()->json(['message' => 'Reseña eliminada']);
    }
}