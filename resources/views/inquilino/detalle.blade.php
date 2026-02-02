<x-inquilino.layout>

    <style>
    /* Hace las imágenes más pequeñas y cuadradas */
    .image-square {
        width: 100%;
        aspect-ratio: 1/1;
        overflow: hidden;
        border-radius: 10px;
    }

    .image-square img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    </style>

    <div class="container my-4">
        <div class="row justify-content-center">

            <div class="col-lg-10 main-content bg-white p-4 rounded shadow-lg">

                <h2 class="mb-3">
                    {{ $prop->titulo }} – {{ $prop->barrio }}
                </h2>

                <ul class="nav nav-tabs mb-4">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Vista general</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="#">Detalles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="#">Comentarios</a>
                    </li>
                    <li class="nav-item ms-3">
                        <a class="btn btn-primary text-white" href="#">Reservar</a>
                    </li>
                </ul>

                <div class="row g-4">

                    {{-- IMÁGENES --}}
                    <div class="col-12 col-md-7">
                        <div class="row g-3">

                            @foreach ($prop->imagenes ?? [] as $img)
                            <div class="col-6">
                                <div class="image-square">
                                    <img src="{{ asset('storage/' . $img->ruta) }}" class="img-fluid rounded"
                                        alt="Imagen propiedad">
                                </div>
                            </div>
                            @endforeach

                            {{-- Imágenes por defecto si no hay --}}
                            @if (($prop->imagenes ?? [])->count() == 0)
                            @foreach (['cuarto1.png', 'cuarto2.png'] as $img)
                            <div class="col-6">
                                <div class="image-square">
                                    <img src="{{ asset('images/' . $img) }}" class="img-fluid rounded">
                                </div>
                            </div>
                            @endforeach
                            @endif

                        </div>
                    </div>

                    {{-- INFORMACIÓN DEL PROPIETARIO --}}
                    <div class="col-12 col-md-5">
                        <div class="card border-0 p-3 shadow-sm">

                            <div class="d-flex align-items-center border-bottom mb-3 pb-3">
                                <div class="rounded-circle me-3 bg-secondary" style="width: 50px; height: 50px;"></div>

                                <div>
                                    <h5 class="mb-0">
                                        {{ $prop->propietario->name ?? 'Propietario no disponible' }}
                                    </h5>
                                    <small class="text-muted">Propietario</small>
                                </div>

                                <button class="btn btn-sm btn-outline-primary ms-auto">Escribir</button>
                            </div>

                            <h6 class="fw-bold">Normas de la Propiedad</h6>
                            <ul class="list-unstyled small mb-3">
                                <li>• No se permite fumar</li>
                                <li>• No se permiten mascotas</li>
                            </ul>

                            <h6 class="fw-bold">Servicios:</h6>
                            <ul class="list-unstyled small">
                                <li>{{ $prop->servicios ?? 'No especificado' }}</li>
                            </ul>

                            <h6 class="fw-bold mt-3">Cercanías:</h6>
                            <ul class="list-unstyled small">
                                <li>{{ $prop->cercanias ?? 'Sin información' }}</li>
                            </ul>

                            <h6 class="fw-bold mt-3">Precio</h6>
                            <p class="fw-bold fs-5">${{ $prop->precio }}</p>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    

</x-inquilino.layout>