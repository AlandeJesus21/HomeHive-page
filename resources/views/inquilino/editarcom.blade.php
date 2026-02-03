<x-inquilino.layout>

    <div class="container py-4">

        <h3 class="fw-bold mb-4">Editar reseña</h3>

        <div class="card border-0 shadow-sm p-4">

            <form action="{{ route('reviews.update', $review->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Calificación --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Calificación</label>
                    <select name="rating" class="form-select" required>
                        @for ($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}" {{ $review->rating == $i ? 'selected' : '' }}>
                            {{ str_repeat('⭐', $i) }}
                        </option>
                        @endfor
                    </select>
                </div>

                {{-- Comentario --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Comentario</label>
                    <textarea name="comentario" class="form-control"
                        rows="4">{{ old('comentario', $review->comentario) }}</textarea>
                </div>

                <button class="btn btn-warning">
                    Actualizar reseña
                </button>

                <a href="{{ route('inquilino.vermas', $review->propiedad_id) }}" class="btn btn-secondary ms-2">
                    Cancelar
                </a>

            </form>

        </div>
    </div>

</x-inquilino.layout>