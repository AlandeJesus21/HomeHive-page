<x-admin.layout>
    <main class="main-content">
        <div class="container cards-wrapper">
            <div class="row justify-content-center">
                <div class="col-12 col-md-4 mb-4">
                    <div class="card border-secondary text-center shadow" onclick="location.href='{{ route('user.index') }}';"
                        style="cursor: pointer;">
                        <img class="rounded-circle d-block mx-auto mt-3" width="80" height="80"
                            src="{{ asset('images/users.jpeg') }}" alt="Logo" />
                        <div class="card-body">
                            <h4 class="card-title">Usuarios</h4>
                            <p class="card-text">Gestión de usuarios</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4 mb-4">
                    <div class="card border-secondary text-center shadow" onclick="location.href='{{ route('properties.index') }}';"
                        style="cursor: pointer;">
                        <img class="rounded-circle d-block mx-auto mt-3" width="80" height="80"
                            src="{{ asset('images/casa.jpeg') }}" alt="Logo" />
                        <div class="card-body">
                            <h4 class="card-title">Propiedades</h4>
                            <p class="card-text">Gestión de propiedades</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>


</x-admin.layout>
