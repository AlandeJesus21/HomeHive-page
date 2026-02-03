<x-inquilino.layout>

    <div class="container py-4">

        <h3 class="fw-bold mb-3">
            Comentarios de {{ $propiedad->titulo }} – {{ $propiedad->barrio }}
        </h3>

        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('inquilino.vermas', $propiedad->id) }}">Vista general</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active">Comentarios</a>
            </li>
        </ul>

        <!-- PROMEDIO -->
        <div class="card border-0 shadow-sm p-3 mb-4">
            <h4 class="fw-bold">
                Promedio:
                <span class="text-warning">
                    {{ number_format($propiedad->reviews->avg('rating'), 1) ?? '0.0' }} ★
                </span>
            </h4>
        </div>

        <!-- LISTA -->
        <div class="card border-0 shadow-sm p-3 mb-4">
            <h5 class="fw-bold">Reseñas</h5>

            @forelse ($propiedad->reviews as $review)
            <div class="border-bottom py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <strong>{{ $review->usuario->name }}</strong>

                    <div>
                        <span class="text-warning me-2">
                            {{ str_repeat('★', $review->rating) }}
                        </span>

                        @auth
                        @if ($review->user_id === auth()->id())
                        <a href="{{ route('reviews.edit', $review->id) }}" class="btn btn-sm btn-outline-warning">
                            Editar
                        </a>

                        <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar reseña?')">
                                Eliminar
                            </button>
                        </form>
                        @endif
                        @endauth
                    </div>
                </div>

                <p class="mb-1">{{ $review->comentario }}</p>
                <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
            </div>
            @empty
            <p class="text-muted">Aún no hay reseñas.</p>
            @endforelse
        </div>

        <!-- FORMULARIO -->
        @auth
        @php
        $yaComento = $propiedad->reviews
        ->where('user_id', auth()->id())
        ->count() > 0;
        @endphp

        @if (!$yaComento)
        <div class="card border-0 shadow-sm p-4">
            <h5 class="fw-bold mb-3">Deja tu reseña</h5>

            <form action="{{ route('reviews.store', $propiedad->id) }}" method="POST">
                @csrf

                <select name="rating" class="form-select mb-3" required>
                    <option value="5">⭐⭐⭐⭐⭐</option>
                    <option value="4">⭐⭐⭐⭐</option>
                    <option value="3">⭐⭐⭐</option>
                    <option value="2">⭐⭐</option>
                    <option value="1">⭐</option>
                </select>

                <textarea name="comentario" class="form-control" rows="3" placeholder="Tu opinión..."></textarea>

                <button class="btn btn-primary mt-3">Enviar reseña</button>
            </form>
        </div>
        @else
        <div class="alert alert-info text-center">
            Ya has comentado esta propiedad.
        </div>
        @endif
        @endauth

    </div>

</x-inquilino.layout>