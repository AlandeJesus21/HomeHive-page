<x-admin.layout>

<?php
// SVG base64 de un ícono de usuario simple (no requiere conexión)
$svg_placeholder = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA1MTIgNTEyIj48cGF0aCBmaWxsPSIjREREREREIiBkPSJNMjU2IDBDMTE0LjYgMCAwIDExNC42IDAgMjU2czExNC42IDI1NiAyNTYgMjU2IDI1Ni0xMTQuNiAyNTYtMjU2UzM5Ny40IDAgMjU2IDBaTTI1NiA3Ni44YzQzLjQgMCA3OC42IDM1LjIgNzguNiA3OC42cy0zNS4yIDc4LjYtNzguNiA3OC42LTc4LjYtMzUuMi03OC42LTc4LjZzMzUuMi03OC42IDc4LjYtNzguNlpNMzcwLjggMzk0LjljLTMwLjktMjAuNi03MS40LTMzLjItMTE0LjgtMzMuMnMtODMuOSA1LjQtMTE0LjggMzMuMmMtMzkuOSAzNi44LTY1LjcgNzAuOC02NS43IDEwMS42aDM2MS4xYy0xLjQtMzAuOC0yNy4yLTY0LjgtNjcuNS0xMDFuLS41eiIvPjwvc3ZnPg==';
?>

<div class="container my-5">
    <h2 class="mb-4 text-black">Ajustes de Perfil</h2>

    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Editar Perfil</h5>
                </div>
                <div class="card-body p-4 p-md-5">

                    <form action="/admin/perfil/update" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="row align-items-center mb-5 border-bottom pb-4">
                            <div class="col-md-4 text-center">
                                <label class="form-label d-block mb-3">Imagen de Perfil Actual</label>

                                <div class="d-flex justify-content-center">
                                    <div class="d-flex align-items-center">
                                        <img class="rounded-circle shadow border border-3 border-secondary"
                                            width="120px"
                                            height="120px"
                                            src="{{asset('images/admin.jpeg')}}"
                                            alt="Imagen de perfil"
                                            style="object-fit: cover; background-color: #f8f9fa;" />
                                    </div>
                                </div>
                                </div>
                            <div class="col-md-8">
                                <label for="perfil_imagen" class="form-label">Subir nueva imagen</label>
                                <input type="file" class="form-control" id="perfil_imagen" name="perfil_imagen" accept="image/*">
                                @error('perfil_imagen')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                <div class="form-text">Formatos permitidos: JPG, PNG. Máx. 2MB.</div>
                            </div>
                        </div>

                        <h5 class="mb-4 text-secondary">Datos Personales</h5>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="name" class="form-label">Nombre Completo</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', 'Bienvenido Admin') }}" required minlength="3" maxlength="100">
                                @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
                                <div class="invalid-feedback">Por favor ingresa tu nombre (3-100 caracteres).</div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono" value="{{ old('telefono', '5512345678') }}" pattern="[0-9]{10}" required>
                                @error('telefono')<div class="text-danger small">{{ $message }}</div>@enderror
                                <div class="invalid-feedback">Ingresa un teléfono válido de 10 dígitos.</div>
                            </div>
                        </div>

                        <hr class="my-4">


                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', 'admin@ejemplo.com') }}" required>
                                @error('email')<div class="text-danger small">{{ $message }}</div>@enderror
                                <div class="invalid-feedback">Ingresa un correo electrónico válido.</div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="password" class="form-label">Nueva Contraseña (Mín. 8 caracteres)</label>
                                <input type="password" class="form-control" id="password" name="password" minlength="8" autocomplete="new-password">
                                @error('password')<div class="text-danger small">{{ $message }}</div>@enderror
                                <div class="form-text">Dejar vacío para mantener la contraseña actual.</div>
                            </div>
                        </div>

                        <div class="col-12 mt-4 text-end">
                            <a href="/" class="btn btn-secondary me-2">
                                <i class="bi bi-x-lg me-1"></i> Cancelar
                            </a>
                            <button type="button" class="btn btn-primary px-4">
                                <i class="bi bi-save me-1"></i> Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</x-admin.layout>
