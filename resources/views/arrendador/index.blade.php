<x-arrendador.layout title="Tus Propiedades - StayGO">

    <div class="container py-5">

        <div class="row mb-4 mx-3">
            <h1 class="text-tu-hogar fw-bold fs-2">Tus propiedades</h1>
        </div>

        <div class="row mx-3" id="propiedades-container">

            @if (isset($propiedades) && count($propiedades) > 0)
            @foreach ($propiedades as $propiedad)

            <div class="col-lg-4 col-md-6 col-12 mb-4">
                <div class="card p-3 shadow-lg border-0 rounded-4 bg-white h-100 d-flex flex-column">

                    <div class="card-header border-0 bg-transparent pb-1">
                        <h4 class="fw-bold text-dark">{{ $propiedad->tipo }}</h4>
                    </div>

                    <div class="card-body pt-0 flex-grow-1">
                        <div class="row g-3">

                            <div class="col-4">
                                <img src="{{ asset('storage/' . $propiedad->imagen) }}"
                                    onerror="this.src='https://placehold.co/100x100/EEEEEE/333333?text=Sin+Imagen'"
                                    class="img-fluid rounded-2" style="height: 100px; object-fit: cover; width: 100px;">
                            </div>

                            <div class="col-8">
                                <h6 class="card-title fw-bold text-dark mb-1 small">{{ $propiedad->titulo }}</h6>

                                <p class="mb-1 small">
                                    <span class="text-warning" data-rating="{{ $propiedad->rating }}"></span>
                                    <span class="text-secondary small me-3">
                                        {{ number_format($propiedad->rating, 1) }}
                                    </span>
                                    <span class="fw-bold text-dark">
                                        ${{ number_format($propiedad->precio, 0, ',', '.') }}
                                    </span>
                                </p>

                                <p class="card-text small text-muted mb-0">{{ $propiedad->barrio }}</p>
                                <p class="card-text small text-muted mb-0">{{ $propiedad->calle }}</p>

                            </div>

                        </div>
                    </div>

                    <div class="p-3 pt-0">
                        <div class="row g-2">
                            <div class="col-6">
                                <button class="btn btn-outline-secondary w-100"
                                    onclick="execute('/editprop/{{ $propiedad->id }}')">
                                    <i class="bi bi-pencil"></i> Editar
                                </button>
                            </div>

                            <div class="col-6">
                                <a class="btn btn-outline-secondary w-100"
                                    href="{{ route('arrendador.reviews', $propiedad->id) }}" <i
                                    class="bi bi-chat-dots"></i> Comentarios
                                </a>
                            </div>

                            <div class="col-6">
                                <button class="btn btn-outline-secondary w-100"
                                    onclick="execute('/propiedades/{{ $propiedad->id }}/reservas')">
                                    <i class="bi bi-calendar-check"></i> Reservas
                                </button>
                            </div>
                            <div class="col-6">
                                <form id="deleteForm-{{ $propiedad->id }}"
                                    action="{{ route('propiedad.destroy', $propiedad->id) }}" method="POST"
                                    onsubmit="return confirm('¿Seguro que deseas eliminar esta propiedad?');">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-outline-danger w-100">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

            @endforeach
            @else
            <div class="col-12 text-center py-5">
                <p class="lead text-muted">Aún no has registrado ninguna propiedad. ¡Comienza ahora!</p>
                <button onclick="execute('/registerprop')" class="btn btn-primary">Registrar Propiedad</button>
            </div>
            @endif

        </div>

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