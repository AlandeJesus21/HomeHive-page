<?php

namespace App\Http\Controllers;

use App\Models\Propiedad;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;   
use Illuminate\Support\Facades\Storage; 
use App\Models\Review;

class PropiedadController extends Controller
{
    // -------------------------------
    // Listado de propiedades del arrendador
    // -------------------------------
    public function index()
    {
        $user = Auth::user();
        $propiedades = Propiedad::where('user_id', $user->id)->get();
        return view('arrendador.index', compact('propiedades', 'user'));
    }

    public function indexin() {
        $user = Auth::user();
        $propiedades = Propiedad::where('user_id', $user->id)->get();
        return view('inquilino.index', compact('propiedades', 'user'));
    }

    // -------------------------------
    // Mostrar formulario de creación
    // -------------------------------
    public function create()
    {
        return view('arrendador.forms.registerprop');
    }

    // -------------------------------
    // Guardar nueva propiedad
    // -------------------------------
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'tipo' => 'required|string',
            'barrio' => 'required|string',
            'calle' => 'required|string',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'precio' => 'required|numeric|min:1',
            'forma_pago' => 'required|string',
            'servicio'   => 'required|string',
            'descripcion' => 'required|string',
            'reglas' => 'required|string',
            'cercanias' => 'required|string',
            'imagen' => 'nullable|image|max:2048',
        ]);

        $propiedad = new Propiedad();
        $propiedad->user_id = Auth::id();
        $propiedad->titulo = $request->titulo;
        $propiedad->tipo = $request->tipo;
        $propiedad->barrio = $request->barrio;
        $propiedad->calle = $request->calle;
        $propiedad->latitud = $request->latitud;
        $propiedad->longitud = $request->longitud;
        $propiedad->precio = $request->precio;
        $propiedad->forma_pago = $request->forma_pago;
        $propiedad->servicio = $request->servicio;
        $propiedad->descripcion = $request->descripcion;
        $propiedad->reglas = $request->reglas;
        $propiedad->cercanias = $request->cercanias;

        if ($request->hasFile('imagen')) {
            $propiedad->imagen = $request->file('imagen')->store('propiedades', 'public');
        }

        $propiedad->save();

        return redirect()->route('arrendador.index')->with('success', 'Propiedad registrada correctamente.');
    }

    // -------------------------------
    // Mostrar formulario de edición
    // -------------------------------
    public function edit(Propiedad $propiedad)
    {
        return view('arrendador.forms.editprop', compact('propiedad'));
    }

    // -------------------------------
    // Actualizar propiedad
    // -------------------------------
    public function update(Request $request, $id)
{
    $propiedad = Propiedad::findOrFail($id);

    $propiedad->titulo = $request->titulo;
    $propiedad->precio = $request->precio;
    $propiedad->tipo = $request->tipo;
    $propiedad->descripcion = $request->descripcion;

    if ($request->hasFile('imagen')) {
        $propiedad->imagen = $request->file('imagen')->store('propiedades', 'public');
    }

    $propiedad->save();

    return redirect()->route('arrendador.index')->with('success', 'Propiedad actualizada.');
}


    // -------------------------------
    // Eliminar propiedad
    // -------------------------------
    public function destroy(Propiedad $propiedad)
    {
        if ($propiedad->imagen) {
            Storage::disk('public')->delete($propiedad->imagen);
        }

        $propiedad->delete();

        return redirect()->route('arrendador.index')->with('success', 'Propiedad eliminada correctamente.');
    }

    // -------------------------------
    // // Descargar imagen de propiedad
    // // -------------------------------
    // public function downloadImage(Propiedad $propiedad)
    // {
    //     if (!$propiedad->imagen || !Storage::disk('public')->exists($propiedad->imagen)) {
    //         abort(404, 'Archivo no encontrado');
    //     }

    //     return Storage::disk('public')->download($propiedad->imagen);
    // }

    public function apiPropiedad() {
        $propiedadess = Propiedad::all();
        return $propiedadess;
    }

    public function reviews()
{
    return $this->hasMany(Review::class);
}

public function ratingPromedio()
{
    return $this->reviews()->avg('rating');
}

public function favoritos()
{
    return $this->belongsToMany(User::class, 'favoritos');
}

public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function viewreviews($id)
{
    $propiedad = Propiedad::findOrFail($id);
    $reviews = $propiedad->reviews()->latest()->get();

    return view('arrendador.vistacome', compact('propiedad', 'reviews'));
}



}