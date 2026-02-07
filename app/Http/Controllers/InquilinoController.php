<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Propiedad;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PropiedadController;


class InquilinoController extends Controller
{
public function inicio()
{
    $propiedades = Propiedad::with('reviews')->get(); 

    return view('inquilino.index', compact('propiedades'));
}


public function vermas($id)
{
    $propiedad = Propiedad::with('reviews')->findOrFail($id);

    // Punto de origen (puede ser fijo o luego la ubicación del usuario)
    $origin = "16.915972,-92.119888";

    // Destino: coordenadas reales del inmueble
    $destination = $propiedad->latitud . ',' . $propiedad->longitud;

    $url = "https://maps.google.com/maps/api/directions/json"
        . "?key=AIzaSyDfwvr04auLWuNeHRtp9AjIUuCavarueJs" 
        . "&origin=$origin"
        . "&destination=$destination";

    $respuesta = file_get_contents($url);
    $json = json_decode($respuesta);

    $distancia = $json->routes[0]->legs[0]->distance->text ?? null;
    $duracion  = $json->routes[0]->legs[0]->duration->text ?? null;
    $resumen   = $json->routes[0]->summary ?? null;

    return view('inquilino.vermas', compact(
        'propiedad',
        'distancia',
        'duracion',
        'resumen'
    ));
}



    public function comentarios($id)
{
    $propiedad = Propiedad::findOrFail($id);

    return view('inquilino.comentarios', compact('propiedad'));
}

public function favoritos()
{
    $user = auth()->user();

    $favoritos = $user->favoritos()->with('reviews')->get();

    return view('inquilino.favoritos', compact('favoritos'));
}


}