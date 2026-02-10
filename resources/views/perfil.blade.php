<!doctype html>
<html lang="es">

<head>
    <title>Editar Perfil - HomeHIve</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
    :root {
        --primary-color: #1f3a8a;
        /* Azul botones */
        --secondary-bg: #f1f5f9;
        /* Fondo gris claro */
        --dark-footer: #1f2937;
        /* Footer */
    }

    body {
        background-color: var(--secondary-bg);
    }

    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        border-radius: 12px;
        padding: 10px 22px;
    }

    .btn-primary:hover {
        background-color: #172554;
        border-color: #172554;
    }

    .profile-img {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        object-fit: cover;
    }
    </style>
</head>

<body>

    <!-- NAVBAR SIMPLE -->
    <nav class="navbar navbar-light bg-white shadow-sm px-4">
        <a class="navbar-brand fw-bold" href="{{ url('/') }}">HomeHIve</a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-outline-danger btn-sm">Cerrar sesión</button>
        </form>
    </nav>

    <div class="container py-5">

        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Editar Perfil</h5>
                    </div>

                    <div class="card-body">

                        <!-- ÉXITO -->
                        @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <!-- ERRORES -->
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif


                        <form action="{{ route('perfil.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="text-center mb-3">
                                @if (Auth::user()->profile_photo)
                                <img src="{{ asset('images/perfiles/' . Auth::user()->profile_photo) }}"
                                    class="profile-img">
                                @else
                                <img src="{{ asset('images/user.svg') }}" class="profile-img">
                                @endif
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nombre</label>
                                <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nueva foto de perfil</label>
                                <input type="file" class="form-control" name="profile_photo">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nueva contraseña (opcional)</label>
                                <input type="password" class="form-control" name="password">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Confirmar contraseña</label>
                                <input type="password" class="form-control" name="password_confirmation">
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Guardar cambios</button>

                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>