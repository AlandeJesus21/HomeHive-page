<?php

namespace App\Http\Controllers;

use App\Models\AppReview;
use Illuminate\Http\Request;

class AppReviewController extends Controller
{
    // Mostrar todas las reseñas
    public function index()
    {
        $reviews = AppReview::with('usuario')->get();
        return view('inquilino.comentopage', compact('reviews'));
    }

    public function main()
    {
        $reviews = AppReview::with('usuario')->get();
        return view('main.comen', compact('reviews'));
    }

    public function mainarren()
    {
        $reviews = AppReview::with('usuario')->get();
        return view('arrendador.comentarios', compact('reviews'));
    }

    // Guardar nueva reseña
    public function store(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:1000',
        ]);

        AppReview::create([
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'comentario' => $request->comentario,
        ]);

        

        return redirect()->back()->with('success', 'Gracias por tu reseña.');
    }
}