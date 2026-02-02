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

    $origin = "16.915972,-92.119888";

    $destination = urlencode(
        $propiedad->calle . ', ' .
        $propiedad->barrio . ', ' .
        $propiedad->ciudad . ', México'
    ); 
// https://maps.google.com/maps/api/directions/json?key=AIzaSyC6ioXLYMUUNVpqc_zfQ4qave1saAkb-Q4&origin=16.915972,-92.119888&destination=17.50017270827112,-92.0105730000001&mode=driving

    $url = "https://maps.google.com/maps/api/directions/json"
        . "?key=AIzaSyC6ioXLYMUUNVpqc_zfQ4qave1saAkb-Q4" 
        . "&origin=$origin"
        . "&destination=$destination"
        . "&mode=driving";

    $respuesta = file_get_contents($url);
    $json = json_decode($respuesta);

    $distancia = $json->routes[0]->legs[0]->distance->text ?? null;
    $duracion  = $json->routes[0]->legs[0]->duration->text ?? null;
    $resumen   = $json->routes[0]->summary ?? null;

    return view('inquilino.vermas', compact(
        'propiedad',
        'destination',
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