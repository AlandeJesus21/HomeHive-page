<x-inquilino.layout>

    <div class="container py-4">

        <!-- Título -->
        <h3 class="fw-bold mb-3">
            Comentarios sobre la aplicación
        </h3>

        <!-- Navegación -->
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Comentarios</a>
            </li>
        </ul>

        <div class="row justify-content-center">
            <div class="col-lg-10">

                <!-- PROMEDIO -->
                <div class="card border-0 shadow-sm p-3 mb-4">
                    <h4 class="fw-bold">
                        Promedio de reseñas:
                        <span class="text-warning">
                            {{ number_format($reviews->avg('rating'), 1) ?? '0.0' }} ★
                        </span>
                    </h4>
                </div>

                <!-- LISTA DE COMENTARIOS -->
                <div class="card border-0 shadow-sm p-3 mb-4">
                    <h5 class="fw-bold">Reseñas recientes</h5>

                    @forelse ($reviews as $review)
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
                    <p class="text-muted">Aún no hay comentarios sobre la aplicación.</p>
                    @endforelse
                </div>

                <!-- FORMULARIO PARA COMENTAR -->
                @auth
                <div class="card border-0 shadow-sm p-4">
                    <h5 class="fw-bold mb-3">Deja tu reseña</h5>

                    <form action="{{ route('app.reviews.store') }}" method="POST">
                        @csrf

                        <label class="fw-semibold mb-1">Calificación</label>
                        <select name="rating" class="form-select mb-3" required>
                            <option value="5">⭐⭐⭐⭐⭐ — Excelente</option>
                            <option value="4">⭐⭐⭐⭐ — Muy bueno</option>
                            <option value="3">⭐⭐⭐ — Bueno</option>
                            <option value="2">⭐⭐ — Regular</option>
                            <option value="1">⭐ — Malo</option>
                        </select>

                        <label class="fw-semibold mb-1">Comentario</label>
                        <textarea name="comentario" class="form-control" rows="3"
                            placeholder="Escribe tu opinión..."></textarea>

                        <button class="btn btn-primary mt-3">
                            Enviar reseña
                        </button>
                    </form>
                </div>
                @else
                <p class="text-center mt-3">
                    <a href="/login">Inicia sesión</a> para dejar una reseña.
                </p>
                @endauth

            </div>
        </div>
    </div>

</x-inquilino.layout>