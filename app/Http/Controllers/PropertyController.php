<?php

namespace App\Http\Controllers;

use App\Models\Propiedad;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $properties = Propiedad::all();

        return view('admin.propiedades.index', compact('properties'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
    public function edit($id)
    {
        $propiedad = Propiedad::findOrFail($id);
        return view('admin.propiedades.edit', compact('propiedad'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $propiedad = Propiedad::findOrFail($id);

    $propiedad->update([
        'titulo' => $request->titulo,
        'tipo' => $request->tipo_prop,
        'barrio' => $request->barrio,
        'calle' => $request->calle,
        'precio' => $request->precio,
    ]);

    if (Auth::check() && Auth::user()->rol === 'admin') {
    $propiedad->estatus = $request->estatus;
    $propiedad->save();
}



    return redirect()->route('properties.index')->with('success', 'Propiedad actualizada.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Propiedad::destroy($id);

        return redirect()->route('properties.index')
            ->with('success', 'Propiedad eliminado correctamente');
    }
}