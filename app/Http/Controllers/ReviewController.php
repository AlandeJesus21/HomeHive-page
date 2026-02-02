<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Propiedad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Guardar una nueva reseña
    public function store(Request $request, $idPropiedad)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:500'
        ]);

        Review::create([
            'propiedad_id' => $idPropiedad,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comentario' => $request->comentario
        ]);

        return back()->with('success', '¡Tu reseña fue publicada!');
    }
}