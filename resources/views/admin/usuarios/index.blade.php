<x-admin.layout>

    <div class="container">
        <h2 class="mt-4 mb-3 fw-bold text-center">Gestión de Usuarios</h2>

        <div class="row justify-content-center">
            <div class="table-responsive border shadow-sm">
                <table id="myTable" class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Contraseña</th>
                            <th>Correo Electrónico</th>
                            <th>Rol</th>
                            <th>Fecha de registro</th>
                            <th class="text-end text-nowrap w-auto">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td class="text-center">
                                @if($user->profile_photo)
                                <img src="{{ asset('storage/' . $user->profile_photo) }}"
                                    alt="Imagen de {{ $user->name }}" class="rounded-circle" width="40" height="40">
                                @endif
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>******</td> {{-- Nunca mostrar el hash real --}}
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->rol }}</td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-pencil"></i> Editar
                                </a>
                                <button class="btn btn-danger btn-sm"
                                    onclick="deleteRecord('/admin/{{ $user->id }}/delete')">
                                    <i class="bi bi-trash"></i> <span class="d-none d-sm-inline">Eliminar</span>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @section('js')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>

    <script>
    const tabla = new DataTable('#myTable', {
        order: [],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
        },
        columnDefs: [{
            orderable: false,
            targets: [0, 6]
        }]
    });
    </script>
    @endsection

</x-admin.layout>