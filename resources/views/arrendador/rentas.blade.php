<x-inquilino.layout>
    <div class="container py-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="fw-bold mb-0">Mis Rentas</h2>
                <p class="text-muted small">Gestiona tus contratos y pagos actuales</p>
            </div>
            <a href="/inquilino" class="btn btn-outline-primary btn-sm rounded-pill">
                <i class="bi bi-search me-1"></i> Buscar más
            </a>
        </div>

        <div class="row g-4">
            {{-- Comprobamos si existen propiedades, si no, mostramos el estado vacío --}}
            @if(isset($propiedadesRentadas) && $propiedadesRentadas->count() > 0)
                @foreach ($propiedadesRentadas as $prop)
                    <div class="col-md-6 col-lg-4">
                        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                            <div class="position-relative">
                                <img src="{{ $prop->imagen ? asset('storage/'.$prop->imagen) : 'https://placehold.co/400x250?text=Mi+Hogar' }}" 
                                     class="card-img-top" alt="propiedad" style="height: 200px; object-fit: cover;">
                                <div class="position-absolute top-0 end-0 m-3">
                                    <span class="badge bg-success shadow-sm px-3 py-2 rounded-pill">
                                        <i class="bi bi-check-circle-fill me-1"></i> Contrato Activo
                                    </span>
                                </div>
                            </div>

                            <div class="card-body p-4">
                                <div class="mb-3">
                                    <h5 class="fw-bold mb-1 text-dark">{{ $prop->tipo }}</h5>
                                    <p class="text-muted small mb-0">
                                        <i class="bi bi-geo-alt-fill text-danger"></i> {{ $prop->barrio }}, {{ $prop->calle }}
                                    </p>
                                </div>
                                
                                <div class="row g-0 bg-light rounded-3 p-3 mb-3 text-center">
                                    <div class="col-6 border-end">
                                        <small class="text-muted d-block">Mensualidad</small>
                                        <span class="fw-bold text-primary">${{ number_format($prop->precio, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">Estado</small>
                                        <span class="fw-bold text-success">Pagado</span>
                                    </div>
                                </div>

                                <div class="d-grid gap-2">
                                    <a href="/inquilino/{{ $prop->id }}/vermas" class="btn btn-primary rounded-3">
                                        Detalles del Contrato
                                    </a>
                                    <button class="btn btn-link btn-sm text-decoration-none text-muted">
                                        <i class="bi bi-download me-1"></i> Descargar último recibo
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                {{-- ESTADO VACÍO: Esto es lo que verás si no pasas datos desde el controlador --}}
                <div class="col-12 text-center py-5">
                    <div class="bg-white d-inline-block p-4 rounded-circle shadow-sm mb-4">
                        <i class="bi bi-house-dash display-1 text-muted"></i>
                    </div>
                    <h3 class="fw-bold">Sin rentas activas</h3>
                    <p class="text-muted mx-auto" style="max-width: 400px;">
                        Actualmente no tienes ningún contrato vigente. Explora nuestras propiedades disponibles en Ocosingo.
                    </p>
                    <a href="/inquilino" class="btn btn-primary btn-lg px-4 rounded-pill mt-3 shadow">
                        Ver Catálogo
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-inquilino.layout>