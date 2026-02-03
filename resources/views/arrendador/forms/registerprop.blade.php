<x-arrendador.layout title="Registro de Propiedades - HomeHIve">

    <style>
    /* Estilos base */
    body {
        background-color: var(--bs-gray-100);
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    main {
        flex-grow: 1;
    }

    /* Ajuste de color para el título de la marca */
    .text-tu-hogar {
        color: var(--bs-gray-700);
    }

    /* Estilos específicos para el formulario */
    .text-HomeHIve {
        color: var(--bs-gray-700);
    }

    .shadow-custom {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    /* Estilo para el logo */
    .navbar-logo {
        height: 32px;
        width: auto;
        border-radius: 50%;
    }

    .main-logo {
        height: 120px;
        width: auto;
        border-radius: 50%;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
    </style>


    <main>
        <div class="container py-5">
            <div class="row">

                <div class="col-lg-6 d-flex flex-column justify-content-center align-items-center text-center">
                    <h2 class="fw-bold mb-3">“Todo gran cambio empieza con un buen lugar”</h2>
                    <p class="mb-5">Encuentra el espacio ideal o compártelo con quien lo necesita.</p>

                    <h1 class="fw-bold text-HomeHIve mb-3">“HomeHive”</h1>

                    <div class="mb-4">
                        <img src="{{ asset('images/Logo2.png')}}" alt="Logo HomeHIve Grande" class="main-logo">
                    </div>

                    <button class="btn btn-outline-secondary btn-lg" onclick="execute('/propiedades')">
                        Ver propiedades
                    </button>
                </div>

                <div class="col-lg-6">
                    <div class="card p-4 shadow-custom border-0 rounded-4 bg-white">
                        <h2 class="text-center fw-bold text-tu-hogar mb-4">Registro de propiedades</h2>

                        <form class="row g-3 needs-validation" action="{{ url('/registerprop') }}"
                            enctype="multipart/form-data" method="POST" novalidate>

                            @csrf

                            <div class="col-12">
                                <label for="titulo" class="form-label">Título de la propiedad:</label>
                                <input type="text" class="form-control" id="titulo" name="titulo"
                                    placeholder="Introduzca el título" required>
                                <div class="invalid-feedback">Por favor, ingrese un título.</div>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Tipo de la Propiedad:</label>
                                <select class="form-select" name="tipo" required>
                                    <option value="" disabled selected>Elija una opción</option>
                                    <option value="cuarto">Cuarto</option>
                                    <option value="casa">Casa</option>
                                    <option value="departamento">Departamento</option>
                                </select>
                                <div class="invalid-feedback">Por favor, seleccione un tipo.</div>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Barrio:</label>
                                <input type="text" class="form-control" name="barrio" placeholder="Barrio" required>
                                <div class="invalid-feedback">Por favor, ingrese un barrio.</div>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Calle:</label>
                                <input type="text" class="form-control" name="calle" placeholder="Calle" required>
                                <div class="invalid-feedback">Ingrese la calle.</div>
                            </div>


                            <div class="col-12">
                                <label class="form-label">Precio:</label>
                                <input type="number" class="form-control" min="1" name="precio" placeholder="Precio"
                                    required>
                                <div class="invalid-feedback">Ingrese un precio válido.</div>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Forma de pago:</label>
                                <select class="form-select" name="forma_pago" required>
                                    <option value="" disabled selected>Seleccione</option>
                                    <option value="efectivo">Efectivo</option>
                                    <option value="transferencia">Transferencia</option>
                                </select>
                                <div class="invalid-feedback">Seleccione una forma de pago.</div>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Servicios:</label><br>

                                <input type="checkbox" name="servicio[]" value="agua" class="form-check-input me-2">
                                <label class="form-check-label">Agua</label>
                                <input type="checkbox" name="servicio[]" value="electricidad"
                                    class="form-check-input me-2">
                                <label class="form-check-label">Luz</label>
                                <input type="checkbox" name="servicio[]" value="internet" class="form-check-input me-2">
                                <label class="form-check-label">Internet</label>
                                <div class="invalid-feedback">Seleccione al menos un servicio.</div>
                            </div>


                            <div class="col-12">
                                <label class="form-label">Descripción:</label>
                                <textarea class="form-control" name="descripcion" rows="3" required></textarea>
                                <div class="invalid-feedback">Ingrese una descripción.</div>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Reglas:</label>
                                <textarea class="form-control" name="reglas" rows="3" required></textarea>
                                <div class="invalid-feedback">Ingrese reglas.</div>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Lugares estrategicos para encontrar la propiedad:</label>
                                <textarea class="form-control" name="cercanias" rows="3"
                                    placeholder="Ingrese cercanías por ejemplo: cerca del IMMS" required></textarea>
                                <div class="invalid-feedback">Ingrese las cercanías.</div>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Imagen de la propiedad:</label>
                                <input type="file" class="form-control" name="imagen" accept="image/*">
                            </div>

                            <div class="col-12 mt-4">
                                <button class="btn btn-dark w-100 btn-lg" type="submit">Publicar</button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </main>


    <x-slot:scripts>

        <script>
        function execute(url) {
            console.log("Simulando redirección a: " + url);
        }

        (() => {
            'use strict'
            const forms = document.querySelectorAll('.needs-validation')
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
        </script>

    </x-slot:scripts>

</x-arrendador.layout>