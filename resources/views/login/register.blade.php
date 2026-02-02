<x-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10">
                <div class="row">

            <div class="col-md-6 text-center mb-4 mb-md-0">
                <h3 class="fw-bold mb-4">"Todo gran cambio empieza con un buen lugar"</h3>
                <p>Encuentra el espacio ideal o compártelo con quien lo necesita.</p>
                <div class="my-4">
                    <img src="{{ asset('images/logo2.png') }}" alt="StayGO" style="max-width:150px;" class="rounded-rectangle" >
                </div>
                <div>
                    <a href="/form/login" class="btn btn-outline-dark">Iniciar sesión</a>
                </div>
            </div>

            <div class="col-md-6">
                <h3 class="fw-bold mb-4 text-center">Registro de usuario</h3>

                <form class="mx-auto" style="max-width: 560px;">
                    <div class="row mb-3 align-items-center">
                        <label class="col-4 col-form-label text-end">Nombre completo:</label>
                        <div class="col-8">
                            <input type="text" class="form-control" placeholder="Introduzca su nombre completo" required>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <label class="col-4 col-form-label text-end">Teléfono:</label>
                        <div class="col-8">
                            <input type="tel" class="form-control" placeholder="Introduzca su número telefónico (+52)" required>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <label class="col-4 col-form-label text-end">Correo electrónico:</label>
                        <div class="col-8">
                            <input type="email" class="form-control" placeholder="Introduzca su correo electrónico" required>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <label class="col-4 col-form-label text-end">Contraseña:</label>
                        <div class="col-8">
                            <input type="password" class="form-control" placeholder="Introduzca su contraseña" required>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <label class="col-4 col-form-label text-end">Confirma contraseña:</label>
                        <div class="col-8">
                            <input type="password" class="form-control" placeholder="Introduzca su contraseña" required>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <label class="col-4 col-form-label text-end">Rol:</label>
                        <div class="col-8">
                            <select class="form-select">
                                <option>Defina su rol</option>
                                <option>Propietario</option>
                                <option>Arrendatario</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <label class="col-4 col-form-label text-end">Imagen de la INE:</label>
                        <div class="col-8">
                            <input type="file" class="form-control" accept="image/logo1.jpg">
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <label class="col-4 col-form-label text-end">Imagen del usuario:</label>
                        <div class="col-8">
                            <input type="file" class="form-control" accept="image/logo1.jpg">
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <button type="submit" class="btn btn-dark w-100">Registrarse</button>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <a href="/login" class="text-decoration-underline">Dar clic si tiene una cuenta</a>
                        </div>
                    </div>
                </form>
            </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
