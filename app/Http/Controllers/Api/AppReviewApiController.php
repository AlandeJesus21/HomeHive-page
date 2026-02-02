<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AppReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppReviewApiController extends Controller
{
    // ---------------------------------------------------------
    // LISTAR TODAS LAS RESEÑAS (PÚBLICO)
    // ---------------------------------------------------------
    public function index()
    {
        $reviews = AppReview::with('usuario')->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $reviews
        ]);
    }

    // ---------------------------------------------------------
    // MOSTRAR UNA RESEÑA
    // ---------------------------------------------------------
    public function show($id)
    {
        $review = AppReview::with('usuario')->find($id);

        if (!$review) {
            return response()->json([
                'success' => false,
                'message' => 'Reseña no encontrada'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $review
        ]);
    }

    // ---------------------------------------------------------
    // CREAR RESEÑA (REQUIERE TOKEN)
    // ---------------------------------------------------------
    public function store(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:1000',
        ]);

        $review = AppReview::create([
            'user_id' => Auth::id(),
            'rating'   => $request->rating,
            'comentario' => $request->comentario,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Gracias por tu reseña.',
            'data' => $review
        ], 201);
    }

    // ---------------------------------------------------------
    // ACTUALIZAR RESEÑA (SOLO EL DUEÑO)
    // ---------------------------------------------------------
    public function update(Request $request, $id)
    {
        $review = AppReview::find($id);

        if (!$review) {
            return response()->json(['success' => false, 'message' => 'Reseña no encontrada'], 404);
        }

        if ($review->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'No autorizado'], 403);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:1000',
        ]);

        $review->update($request->only(['rating', 'comentario']));

        return response()->json([
            'success' => true,
            'message' => 'Reseña actualizada correctamente',
            'data' => $review
        ]);
    }

    // ---------------------------------------------------------
    // ELIMINAR RESEÑA (SOLO EL DUEÑO)
    // ---------------------------------------------------------
    public function destroy($id)
    {
        $review = AppReview::find($id);

        if (!$review) {
            return response()->json(['success' => false, 'message' => 'Reseña no encontrada'], 404);
        }

        if ($review->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'No autorizado'], 403);
        }

        $review->delete();

        return response()->json([
            'success' => true,
            'message' => 'Reseña eliminada correctamente'
        ]);
    }
}