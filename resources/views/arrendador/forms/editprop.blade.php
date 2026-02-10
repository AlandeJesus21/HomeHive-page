<x-arrendador.layout title="Modificación de Propiedades - HomeHIve">

    <style>
    /* .navbar-logo {
        height: 32px;
        width: auto;
        border-radius: 50%;
    } */

    .main-logo {
        height: 120px;
        width: auto;
        border-radius: 50%;
    }

    .card-form {
        padding: 40px;
    }

    .left-panel {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        height: 100%;
    }

    .HomeHIve-logo {
        font-family: serif;
        font-size: 2.5rem;
        font-weight: bold;
        color: var(--bs-body-color);
        margin-bottom: 5px;
    }
    </style>

    <main>
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="row g-4">

                        <div class="col-lg-5 d-flex">
                            <div class="left-panel">
                                <h2 class="fw-bold fs-2 mb-3">“Todo gran cambio empieza con un buen lugar”</h2>
                                <p class="text-muted mb-4">Encuentra el espacio ideal o compártelo con quien lo
                                    necesita.</p>
                                <h3 class="HomeHIve-logo">“HomeHive”</h3>

                                <div class="mb-4">
                                    <img src="{{ asset('images/Logo2.png') }}" alt="Logo HomeHIve Grande"
                                        class="main-logo bg-light">
                                </div>

                                <a href="/arrendador" class="btn btn-outline-secondary border-2 text-dark">
                                    Ver propiedades
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-7 d-flex">
                            <div class="card card-form shadow-lg border-0 rounded-4 bg-white w-100">
                                <h1 class="text-dark fw-bold fs-4 mb-4">Modificación de propiedades</h1>

                                {{-- FORMULARIO --}}
                                <div class="mb-3">
                                    <label class="form-label small text-muted">Título:</label>
                                    <input id="titulo" type="text" class="form-control" value="{{ $propiedad->titulo }}"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small text-muted">Precio:</label>
                                    <input id="precio" type="number" class="form-control"
                                        value="{{ $propiedad->precio }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small text-muted">Tipo:</label>
                                    <select id="tipo" class="form-select" required>
                                        <option value="Cuarto" {{ $propiedad->tipo == 'Cuarto' ? 'selected' : '' }}>
                                            Cuarto</option>
                                        <option value="Apartamento"
                                            {{ $propiedad->tipo == 'Apartamento' ? 'selected' : '' }}>Apartamento
                                        </option>
                                        <option value="Casa" {{ $propiedad->tipo == 'Casa' ? 'selected' : '' }}>Casa
                                        </option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small text-muted">Reglas</label>
                                    <input id="reglas" type="text" class="form-control"
                                        value="{{ $propiedad->reglas }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small text-muted">Descripción:</label>
                                    <input id="descripcion" type="text" class="form-control"
                                        value="{{ $propiedad->descripcion }}" required>
                                </div>



                                <div class="mb-4">
                                    <label class="form-label small text-muted">Imagen actual:</label><br>

                                    @if($propiedad->imagen)
                                    <img src="{{ asset('storage/' . $propiedad->imagen) }}" alt="Imagen de la propiedad"
                                        class="img-thumbnail mb-2" style="max-width: 200px;">
                                    @else
                                    <p class="text-muted">No hay imagen</p>
                                    @endif
                                </div>

                                <div class="mb-4">
                                    <label class="form-label small text-muted">Cambiar imagen:</label>
                                    <input id="imagen" name="imagen" type="file" class="form-control">
                                </div>


                                <button class="btn btn-primary w-100 py-2"
                                    onclick="updatePropiedad({{ $propiedad->id }})">
                                    Guardar cambios
                                </button>

                                <script>
                                async function updatePropiedad(id) {
                                    const formData = new FormData();
                                    formData.append('titulo', document.getElementById('titulo').value);
                                    formData.append('precio', document.getElementById('precio').value);
                                    formData.append('tipo', document.getElementById('tipo').value);
                                    formData.append('descripcion', document.getElementById('descripcion').value);

                                    let imagenFile = document.getElementById('imagen').files[0];
                                    if (imagenFile) {
                                        formData.append('imagen', imagenFile);
                                    }

                                    formData.append('_method', 'PUT');
                                    formData.append('_token', '{{ csrf_token() }}');

                                    const response = await fetch(`/updateprop/${id}`, {
                                        method: "POST",
                                        body: formData
                                    });

                                    if (response.ok) {
                                        alert("Propiedad actualizada correctamente");
                                        window.location.href = "/arrendador";
                                    } else {
                                        alert("Error al actualizar la propiedad");
                                    }
                                }
                                </script>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>

</x-arrendador.layout>