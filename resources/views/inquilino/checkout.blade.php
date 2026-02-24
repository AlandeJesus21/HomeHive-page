<x-inquilino.layout>
    <style>
    .mini-img {
        width: 100%;
        height: 140px;
        object-fit: cover;
        border-radius: 10px;
    }

    .main-prop-img {
        height: 300px;
        width: 100%;
        object-fit: cover;
        border-radius: 15px;
    }
    </style>

    <div class="container py-4">
        {{-- Botón Regresar --}}
        <div class="mb-4">
            <a href="{{ route('inquilino.vermas', $propiedad->id) }}" class="btn btn-outline-secondary btn-sm">
                ← Regresar
            </a>
        </div>

        <div class="row g-4">
            {{-- Columna Izquierda: Galería de Imágenes --}}
            <div class="col-12 col-md-7">
                <div class="mb-3">
                    <img src="{{ $propiedad->imagen ? asset('storage/'.$propiedad->imagen) : 'https://placehold.co/600x400?text=Sin+Imagen' }}"
                        class="main-prop-img shadow-sm" alt="propiedad">
                </div>
                <div class="row g-3">
                    <div class="col-6 col-sm-3"><img src="{{ asset('images/cuarto1.png') }}" class="mini-img shadow-sm">
                    </div>
                    <div class="col-6 col-sm-3"><img src="{{ asset('images/cuarto2.png') }}" class="mini-img shadow-sm">
                    </div>
                    <div class="col-6 col-sm-3"><img src="{{ asset('images/cuarto3.png') }}" class="mini-img shadow-sm">
                    </div>
                    <div class="col-6 col-sm-3"><img src="{{ asset('images/cuarto4.png') }}" class="mini-img shadow-sm">
                    </div>
                </div>
            </div>

            {{-- Columna Derecha: Ficha de Información y Pago --}}
            <div class="col-12 col-md-5">
                <div class="card shadow-sm border-0 rounded-4 p-4 h-100">
                    {{-- Título dentro de la ficha --}}
                    <h3 class="fw-bold mb-1">{{ $propiedad->titulo }}</h3>
                    <p class="text-muted mb-3 small">{{ $propiedad->barrio }}, {{ $propiedad->calle }}</p>

                    @php
                    $rating = $propiedad->reviews->avg('rating') ?? 0;
                    $full = floor($rating);
                    $half = ($rating - $full) >= 0.5;
                    @endphp

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-warning fs-5">
                            @for ($i = 1; $i <= $full; $i++) ★ @endfor @if ($half) ⯪ @endif @for ($i=$full + ($half ? 1
                                : 0); $i < 5; $i++) ☆ @endfor <small class="text-muted">
                                ({{ number_format($rating, 1) }})</small>
                        </span>
                        <span class="fw-bold fs-4 text-success">
                            ${{ number_format($propiedad->precio, 2) }}
                        </span>
                    </div>

                    <div class="property-details mb-4">
                        <p class="mb-1 text-secondary"><strong>Barrio:</strong> {{ $propiedad->barrio }}</p>
                        <p class="mb-1 text-secondary"><strong>Calle:</strong> {{ $propiedad->calle }}</p>
                        <p class="mb-3 text-secondary"><strong>Forma de pago:</strong> {{ $propiedad->forma_pago }}</p>

                        <hr>
                        <p class="mb-1"><strong>Descripción General:</strong></p>
                        <p class="small text-muted">{{ $propiedad->descripcion }}</p>
                    </div>

                    {{-- Sección de Pago Stripe --}}
                    <div class="mt-auto">
                        <form action="{{ route('checkout.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="propiedad_id" value="{{ $propiedad->id }}">
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                Confirmar y Pagar ${{ number_format($propiedad->precio, 2) }}
                            </button>
                        </form>
                        <p class="text-center text-muted small mt-2">Transacción segura</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Mapa --}}
        <div class="row mt-5">
            <div class="col-12 text-center">
                <div class="rounded-4 overflow-hidden shadow-sm mb-3">
                    <iframe width="100%" height="270" style="border:0" loading="lazy" allowfullscreen
                        src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDfwvr04auLWuNeHRtp9AjIUuCavarueJs&q={{ $propiedad->latitud }},{{ $propiedad->longitud }}&zoom=18">
                    </iframe>
                </div>
            </div>
        </div>
</x-inquilino.layout>