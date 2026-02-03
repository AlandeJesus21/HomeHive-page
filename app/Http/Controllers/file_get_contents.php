<?php 
    public function vermas($id)
{
    $propiedad = Propiedad::with('reviews')->findOrFail($id);

    $origin = "16.915972,-92.119888";

    $destination = urlencode(
    $propiedad->calle . ', ' .
$propiedad->barrio . ', ' .
$propiedad->ciudad . ', México'
);

$url = "https://maps.google.com/maps/api/directions/json"
. "?key= AIzaSyC6ioXLYMUUNVpqc_zfQ4qave1saAkb-Q4"
. "&origin=$origin"
. "&destination=$destination"
. "&mode=driving";

$respuesta = file_get_contents($url);
$json = json_decode($respuesta);

$distancia = $json->routes[0]->legs[0]->distance->text ?? null;
$duracion = $json->routes[0]->legs[0]->duration->text ?? null;
$resumen = $json->routes[0]->summary ?? null;

return view('inquilino.vermas', compact(
'propiedad',
'destination',  
'distancia',
'duracion',
'resumen'
));
}
?>