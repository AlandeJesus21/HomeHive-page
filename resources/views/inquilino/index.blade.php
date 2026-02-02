<x-inquilino.layout>

    <div class="container py-4">

        <div class="row justify-content-center g-4">
            @foreach ($propiedades as $prop)

            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-4">

                    <div class="card-body text-center p-3">

                        <h5 class="fw-bold">{{ $prop->tipo }}</h5>
                        <p class="text-muted small mb-2">{{ $prop->descripcion }}</p>

                        <img src="{{ $prop->imagen ? asset('storage/'.$prop->imagen) : 'https://placehold.co/300x200?text=Sin+Imagen' }}"
                            class="img-fluid rounded mb-2" alt="propiedad">

                        <p class="fw-semibold mb-1">
                            ${{ number_format($prop->precio, 0, ',', '.') }}
                        </p>

                        <p class="text-muted small">
                            {{ $prop->barrio }} {{ $prop->calle }}, Ocosingo, Chiapas
                        </p>

                        {{-- ÍCONO DE FAVORITO EN LA ESQUINA --}}
                        <form action="{{ route('favoritos.toggle', $prop->id) }}" method="POST"
                            class="position-absolute top-0 end-0 m-2">
                            @csrf

                            @php
                            $favorito = auth()->user()->favoritos->contains($prop->id);
                            @endphp

                            <button type="submit" class="btn btn-light border rounded-circle p-2"
                                title="{{ $favorito ? 'Quitar de favoritos' : 'Añadir a favoritos' }}">

                                @if ($favorito)
                                <i class="bi bi-bookmark-fill"></i>
                                @else
                                <i class="bi bi-bookmark"></i>
                                @endif
                            </button>
                        </form>



                        <a href="/inquilino/{{ $prop->id }}/vermas" class="btn btn-outline-dark btn-sm">
                            Ver más
                        </a>

                    </div>

                </div>
            </div>

            @endforeach
        </div>


    </div>

</x-inquilino.layout>