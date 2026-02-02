<x-arrendador.layout>

    <div class="container py-4">

        <!-- Título -->
        <h3 class="fw-bold mb-3">
            Comentarios de {{ $propiedad->titulo }} – {{ $propiedad->barrio }}
        </h3>

        <!-- Navegación -->

        <div class="row justify-content-center">
            <div class="col-lg-10">

                <!-- PROMEDIO -->
                <div class="card border-0 shadow-sm p-3 mb-4">
                    <h4 class="fw-bold">
                        Promedio de reseñas:
                        <span class="text-warning">
                            {{ number_format($propiedad->reviews->avg('rating'), 1) ?? '0.0' }} ★
                        </span>
                    </h4>
                </div>

                <!-- LISTA DE COMENTARIOS -->
                <div class="card border-0 shadow-sm p-3 mb-4">
                    <h5 class="fw-bold">Reseñas recientes</h5>

                    @forelse ($propiedad->reviews as $review)
                    <div class="border-bottom py-3">
                        <div class="d-flex justify-content-between">
                            <strong>{{ $review->usuario->name }}</strong>
                            <span class="text-warning">
                                {{ str_repeat('★', $review->rating) }}
                            </span>
                        </div>
                        <p class="mb-1">{{ $review->comentario }}</p>
                        <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                    </div>
                    @empty
                    <p class="text-muted">Aún no hay comentarios para esta propiedad.</p>
                    @endforelse
                </div>


            </div>
        </div>
    </div>

</x-arrendador.layout>