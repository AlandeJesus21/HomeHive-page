<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Propiedad;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PropiedadController;
use App\Models\Renta;





class InquilinoController extends Controller

{

public function inicio()

{

    $propiedades = Propiedad::with('reviews')
        ->where('status', 'libre') 
        ->get();

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



public function rentas()
{
    // Obtenemos las rentas del usuario logueado con su relación de propieda
    $rentas = \App\Models\Renta::where('user_id', auth()->id())
                ->with('propiedad')
                ->get();
    // Extraemos las propiedades para que tu vista (que usa $propiedadesRentadas) funcione
    $propiedadesRentadas = $rentas->pluck('propiedad');
    return view('inquilino.rentas', compact('propiedadesRentadas'));

}

}