<x-inquilino.layout>

    <div class="container py-4">

        <h3 class="fw-bold mb-4">Mis Favoritos ❤️</h3>

        @if ($favoritos->count() === 0)
        <div class="text-center text-muted py-5">
            <h5>No tienes propiedades guardadas.</h5>
            <p>Ve al listado y agrega algunas ⭐</p>
        </div>
        @else

        <div class="row g-4">
            @foreach ($favoritos as $prop)
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-4 position-relative">

                    <div class="card-body text-center p-3">

                        <h5 class="fw-bold">{{ $prop->tipo }}</h5>
                        <p class="text-muted small mb-2">{{ $prop->descripcion }}</p>

                        <img src="{{ $prop->imagen ? asset('storage/'.$prop->imagen) : 'https://placehold.co/300x200?text=Sin+Imagen' }}"
                            class="img-fluid rounded mb-2" alt="propiedad">

                        {{-- ⭐ Cálculo de rating --}}
                        @php
                        $rating = $prop->reviews->avg('rating') ?? 0;
                        $full = floor($rating);
                        $half = ($rating - $full) >= 0.5;
                        @endphp

                        <div class="text-warning mb-2">
                            @for ($i = 1; $i <= $full; $i++) ★ @endfor @if ($half) ⯪ @endif @for ($i=$full + ($half ? 1
                                : 0); $i < 5; $i++) ☆ @endfor <span class="text-dark small">
                                {{ number_format($rating, 1) }}</span>
                        </div>

                        <p class="fw-semibold mb-1">
                            ${{ number_format($prop->precio, 0, ',', '.') }}
                        </p>

                        <p class="text-muted small">
                            {{ $prop->ubicacion }}, Ocosingo, Chiapas
                        </p>

                        <a href="/inquilino/{{ $prop->id }}/vermas" class="btn btn-outline-dark btn-sm">
                            Ver más
                        </a>

                    </div>

                    {{-- ❌ Botón para quitar de favoritos --}}
                    <form action="/favoritos/{{ $prop->id }}/eliminar" method="POST"
                        class="position-absolute top-0 end-0 m-2">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-light border rounded-circle" title="Quitar de favoritos">
                            <i class="bi bi-bookmark-x"></i>
                        </button>
                    </form>

                </div>
            </div>
            @endforeach
        </div>

        @endif

    </div>

</x-inquilino.layout>