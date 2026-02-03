<x-inquilino.layout>

    <style>
    .mini-img {
        width: 100%;
        height: 140px;
        object-fit: cover;
        border-radius: 10px;
    }
    </style>

    <div class="container py-4">

        <h3 class="fw-bold mb-3">
            {{ $propiedad->titulo }} – {{ $propiedad->barrio }}
        </h3>

        <ul class="nav nav-underline mb-4">
            <li class="nav-item">
                <a class="nav-link active" href="#">Vista general</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('inquilino.comentarios', $propiedad->id) }}">Comentarios</a>
            </li>
            <li class="nav-item ms-auto">
                <a class="btn btn-primary text-white" href="#">Reservar</a>
            </li>
        </ul>

        <div class="row g-4">

            <div class="col-12 col-md-7">
                <div class="row g-3">
                    <div class="col-6"><img src="{{ asset('images/cuarto1.png') }}" class="mini-img shadow-sm"></div>
                    <div class="col-6"><img src="{{ asset('images/cuarto2.png') }}" class="mini-img shadow-sm"></div>
                    <div class="col-6"><img src="{{ asset('images/cuarto3.png') }}" class="mini-img shadow-sm"></div>
                    <div class="col-6"><img src="{{ asset('images/cuarto4.png') }}" class="mini-img shadow-sm"></div>
                </div>
            </div>

            <div class="col-12 col-md-5">
                <div class="card shadow-sm border-0 rounded-4 p-3">

                    @php
                    $rating = $propiedad->reviews->avg('rating') ?? 0;
                    $full = floor($rating);
                    $half = ($rating - $full) >= 0.5;
                    @endphp

                    <p class="mb-1">
                        <strong>
                            @for ($i = 1; $i <= $full; $i++) ★ @endfor @if ($half) ⯪ @endif @for ($i=$full + ($half ? 1
                                : 0); $i < 5; $i++) ☆ @endfor {{ number_format($rating, 1) }} </strong>

                                <span class="float-end fw-semibold">
                                    Precio: ${{ $propiedad->precio }}
                                </span>
                    </p>

                    <p class="mb-1"><strong>Tipo de propiedad:</strong> {{ $propiedad->tipo_prop }}</p>
                    <p class="mb-1"><strong>Barrio:</strong> {{ $propiedad->barrio }}</p>
                    <p class="mb-1"><strong>Calle:</strong> {{ $propiedad->calle }}</p>
                    <p class="mb-2"><strong>Forma de pago:</strong> {{ $propiedad->forma_pago }}</p>

                    <p class="mb-0"><strong>Descripción General:</strong></p>
                    <p class="small text-muted">{{ $propiedad->descripcion }}</p>

                </div>
            </div>
            <iframe width="260" height="270" style="border:0" loading="lazy" allowfullscreen
                referrerpolicy="no-referrer-when-downgrade" src="https://www.google.com/maps/embed/v1/directions?key=AIzaSyDfwvr04auLWuNeHRtp9AjIUuCavarueJs
    &origin=16.9083133,-92.119888&destination=17.50017270827112,-92.0105730000001">
            </iframe>

        </div>

        <?php    
    $respuesta = file_get_contents("https://maps.google.com/maps/api/directions/json?key=AIzaSyC6ioXLYMUUNVpqc_zfQ4qave1saAkb-Q4&origin=16.915972,-92.119888&destination=17.50017270827112,-92.0105730000001&mode=driving");

    $json = json_decode($respuesta);
    
    $distancia = $json->{"routes"}[0]->{"legs"}[0]->{"distance"}->{"text"};
    $duracion = $json->{"routes"}[0]->{"legs"}[0]->{"duration"}->{"text"};
    $resumen = $json->{"routes"}[0]->{"summary"};

    echo "<center><b> $resumen </b><br><b>Distancia: $distancia</b>. Duración: $duracion</b></center>";

    ?>


    </div>

    </x-layout>