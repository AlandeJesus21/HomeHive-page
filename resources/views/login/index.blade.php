<x-layout>
    <div class="container py-5">
        <div class="row align-items-center">

            <div class="col-md-6 text-center mb-4 mb-md-0">
                <h3 class="fw-bold mb-4">"Todo gran cambio empieza con un buen lugar"</h3>
                <p>Encuentra el espacio ideal o compártelo con quien lo necesita.</p>
                <div class="my-4">
                    <img src="{{ asset('images/logo2.png') }}" alt="StayGO" style="max-width:130px;" class="">
                </div>
                <div>
                    <a href="/form/register" class="btn btn-outline-dark">Registrarse</a>
                </div>
                <p class="mt-3"><a href="/register" class="text-decoration-underline">Dar clic si no tiene una
                        cuenta</a></p>
            </div>


            <div class="col-md-6">
                <h3 class="fw-bold mb-4 text-center">Inicio de sesión</h3>

                <form class="mx-auto" style="max-width: 560px;">
                    <div class="row mb-3 align-items-center">
                        <label class="col-4 col-form-label text-end">Correo electrónico:</label>
                        <div class="col-8">
                            <input type="email" class="form-control" placeholder="Introduzca su correo" required>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <label class="col-4 col-form-label text-end">Contraseña:</label>
                        <div class="col-8">
                            <input type="password" class="form-control" placeholder="Introduzca su contraseña" required>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-dark">Iniciar sesión</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        if (!form) return;

        const USERS = [{
                email: 'arrendador@gmail.com',
                password: '1234',
                redirect: '/arrendador'
            },
            {
                email: 'inquilino@gmail.com',
                password: '1234',
                redirect: '/inquilino'
            },
            {
                email: 'admin@gmail.com',
                password: '1234',
                redirect: '/admin'
            }
        ];

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = form.querySelector('input[type="email"]').value.trim();
            const pass = form.querySelector('input[type="password"]').value;

            const user = USERS.find(u => u.email === email && u.password === pass);
            if (user) {
                alert('Inicio de sesión correcto. Redirigiendo...');
                window.location.href = user.redirect;
            } else {
                alert('Correo o contraseña incorrectos.');
            }
        });
    });
    </script>
</x-layout>