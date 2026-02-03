<x-arrendador.layout title="Reseñas - HomeHIve">

    <div class="container py-5">

        <h1 class="fw-bold mb-4">Reseñas de la aplicación</h1>

        <!-- Promedio de reseñas -->
        <div class="card shadow-sm p-3">
            <h4 class="fw-bold">
                Promedio de calificación:
                <span class="text-warning">
                    {{ number_format($reviews->avg('rating') ?? 0, 1) }} ★
                </span>
            </h4>
        </div>

        <!-- Lista de reseñas -->
        <div class="card shadow-sm p-3 mt-3">
            <h5 class="fw-bold mb-3">Reseñas recientes</h5>

            @forelse($reviews as $review)
            <div class="border-bottom py-2">
                <div class="d-flex justify-content-between">
                    <strong>{{ $review->usuario->name }}</strong>
                    <span class="text-warning">{{ str_repeat('★', $review->rating) }}</span>
                </div>

                <p class="mb-1">{{ $review->comentario }}</p>
                <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
            </div>
            @empty
            <p class="text-muted">Aún no hay reseñas.</p>
            @endforelse
        </div>

        <!-- Formulario para dejar reseña -->
        @auth
        <div class="card shadow-sm p-3 mt-3">
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
                <textarea name="comentario" class="form-control mb-3" rows="3"
                    placeholder="Escribe tu opinión..."></textarea>

                <button class="btn btn-primary">Enviar reseña</button>
            </form>
        </div>
        @else
        <p class="mt-3 text-center">
            <a href="{{ route('login') }}">Inicia sesión</a> para dejar una reseña.
        </p>
        @endauth

    </div>

    {{-- SCRIPTS --}}
    <x-slot:scripts>

        <script>
        function execute(url) {
            window.location.href = url;
        }

        function getStarRatingHtml(rating) {
            const fullStar = '<i class="bi bi-star-fill"></i>';
            const halfStar = '<i class="bi bi-star-half"></i>';
            const emptyStar = '<i class="bi bi-star"></i>';

            let stars = '';
            const roundedRating = Math.round(rating * 2) / 2;

            for (let i = 1; i <= 5; i++) {
                if (roundedRating >= i) {
                    stars += fullStar;
                } else if (roundedRating === i - 0.5) {
                    stars += halfStar;
                } else {
                    stars += emptyStar;
                }
            }

            return stars;
        }

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('[data-rating]').forEach(element => {
                const rating = parseFloat(element.getAttribute('data-rating'));
                if (!isNaN(rating)) {
                    element.innerHTML = getStarRatingHtml(rating);
                }
            });
        });
        </script>

    </x-slot:scripts>

</x-arrendador.layout>