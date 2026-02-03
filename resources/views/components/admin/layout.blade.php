<!doctype html>
<html lang="es">

<head>
    <title>Admin - HomeHIve</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
    body {
        background-color: var(--bs-gray-100);
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    main {
        flex-grow: 1;
    }

    .navbar-logo {
        height: 36px;
        width: auto;
        border-radius: 50%;
    }

    .text-tu-hogar {
        color: var(--bs-gray-700);
    }
    </style>
</head>

<body>

    <!-- NAVBAR ADMIN -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm border-bottom">
            <div class="container-fluid mx-5">

                <!-- LOGO -->
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/admin') }}">
                    <img src="{{ asset('images/Logo2.png') }}" alt="Logo HomeHIve" class="navbar-logo me-2">
                    <span class="fw-bold text-tu-hogar fs-5">HomeHIve Admin</span>
                </a>

                <!-- PERFIL SIEMPRE VISIBLE (MÓVIL + ESCRITORIO) -->
                <div class="dropdown order-lg-2 ms-2">

                    <button class="btn p-0 border-0 bg-transparent" data-bs-toggle="dropdown">

                        <div class="d-flex align-items-center">
                            <!-- Nombre solo en escritorio -->
                            <span class="text-muted me-2 small d-none d-lg-inline">{{ Auth::user()->name }}</span>

                            <img src="{{ Auth::user()->profile_photo 
                                ? asset('images/perfiles/' . Auth::user()->profile_photo) 
                                : asset('images/user.svg') }}" class="rounded-circle" width="38" height="38"
                                style="object-fit: cover;">
                        </div>

                    </button>

                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">

                        <li>
                            <a class="dropdown-item" href="/perfil">
                                <i class="bi bi-person me-2"></i> Perfil
                            </a>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i> Cerrar sesión
                                </button>
                            </form>
                        </li>

                    </ul>
                </div>

                <!-- BOTÓN SANDWICH -->
                <button class="navbar-toggler order-lg-1" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarAdmin">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- MENÚ COLAPSABLE -->
                <div class="collapse navbar-collapse order-lg-0" id="navbarAdmin">

                    <ul class="navbar-nav ms-auto">

                        <li class="nav-item">
                            <a class="nav-link text-dark" href="{{ url('/admin') }}">Inicio</a>
                        </li>

                        <!-- Aquí puedes agregar más links si los necesitas
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="{{ route('properties.index') }}">Propiedades</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link text-dark" href="{{ url('/admin/inquilinos') }}">Usuarios</a>
                        </li>
                        -->

                    </ul>

                </div>

            </div>
        </nav>
    </header>

    <!-- CONTENIDO -->
    <main class="container py-4">
        {{ $slot }}
    </main>

    <!-- FOOTER -->
    <footer class="bg-dark text-white py-4 mt-auto text-center">
        <p class="mb-1">© 2025 HomeHIve - Administración</p>
        <small>Panel de control para gestores y administradores</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>