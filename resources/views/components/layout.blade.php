<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomeHive</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">

</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg bg-white shadow-sm">
        <div class="container">

            <!-- LOGO -->
            <a class="navbar-brand fw-bold" href="/">
                <img src="{{ asset('images/Logo2.png') }}" alt="HomeHIve" width="40" class="me-2">
                HomeHive
            </a>

            <!-- PERFIL SIEMPRE VISIBLE -->
            @auth
            <div class="dropdown order-lg-2 ms-2">

                <button class="btn p-0 border-0 bg-transparent" data-bs-toggle="dropdown">
                    <div class="d-flex align-items-center">
                        <span class="text-muted me-2 small d-none d-lg-inline">
                            {{ Auth::user()->name }}
                        </span>

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
            @endauth

            <!-- BOTÓN HAMBURGUESA -->
            <button class="navbar-toggler order-lg-1" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- MENÚ -->
            <div class="collapse navbar-collapse order-lg-0" id="navbarMain">
                <ul class="navbar-nav ms-auto">

                    <li class="nav-item"><a class="nav-link" href="/">Inicio</a></li>

                    @guest
                    <li class="nav-item"><a class="nav-link" href="/register">Registrarse</a></li>
                    <li class="nav-item"><a class="nav-link" href="/login">Iniciar sesión</a></li>
                    @endguest

                </ul>
            </div>

        </div>
    </nav>

    <main>
        {{ $slot }}
    </main>


    <section class="footer bg-light mt-5">
        <!-- Footer -->
        <footer class="bg-dark text-white text-center">


            <!-- Grid container -->
            <div class="container p-4">
                <section class="mb-4">
                    <!-- Facebook -->
                    <a data-mdb-ripple-init class="text-white me-3" href="#!" role="button"><i
                            class="bi bi-facebook"></i></a>

                    <!-- Twitter -->
                    <a data-mdb-ripple-init class="text-white me-3" href="#!" role="button"><i
                            class="bi bi-instagram"></i></a>

                    <!-- Google -->
                    <a data-mdb-ripple-init class="text-white me-3" href="#!" role="button"><i
                            class="bi bi-tiktok"></i></a>
                </section>
                <!--Grid row-->
                <div class="row">
                    <!--Grid column-->
                    <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                        <h5 class="text-uppercase">Compromiso</h5>

                        <p>
                            En HomeHive, nos dedicamos a ofrecer la mejor experiencia en alquileres de propiedades.
                            Valoramos tus comentarios y sugerencias para mejorar continuamente nuestra plataforma y
                            servicios.
                        </p>
                    </div>
                    <!--Grid column-->

                    <!--Grid column-->
                    <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                        <h5 class="text-uppercase">Más </h5>

                        <ul class="list-unstyled mb-0">
                            <li>
                                <a class="text-white me-3" href="/comen">Comentarios</a>

                            </li>
                            <li>
                                <a class="text-white me-3" href="/acerca">Acerca de nosotros</a>

                            </li>
                            <!-- <li>
                                <a href="#!" class="text-body">Link 3</a>
                            </li>
                            <li>
                                <a href="#!" class="text-body">Link 4</a>
                            </li> -->
                        </ul>


                    </div>
                    <!--Grid column-->

                    <!--Grid column-->
                    <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                        <h5 class="text-uppercase mb-0">Legal</h5>

                        <ul class="list-unstyled">
                            <li><a class="text-white me-3" href="/privacidad">Política de privacidad</a></li>
                            <li><a class="text-white me-3" href="/terminos">Términos y condiciones</a></li <li>
                            <a href="#!" class="text-body">Link 3</a>
                            </li>
                        </ul>
                    </div>
                    <!--Grid column-->
                </div>
                <!--Grid row-->
            </div>
            <!-- Grid container -->

            <!-- Copyright -->
            <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
                © 2026 Copyright:
                <a class="text-reset fw-bold" href="/">HomeHive.com</a>
            </div>
            <!-- Copyright -->
        </footer>
        <!-- Footer -->
    </section>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</body>

</html>