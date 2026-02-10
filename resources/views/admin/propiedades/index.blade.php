<x-admin.layout>
    <div class="container">
        <h2 class="mt-4 mb-3 fw-bold text-center">Listado de Propiedades</h2>

        <div class="d-flex justify-content-end">
            <a href="/propiedades/reporte" class="btn btn-primary"> Generar reporte</a>
        </div>
        <div class=" row justify-content-center">
            <div class="table-responsive border shadow-sm">
                <table id="tablaPropiedades" class="table table-striped table-hover mb-0 align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Título</th>
                            <th>Tipo</th>
                            <th>Barrio</th>
                            <th>Arrendador</th>
                            <th class="text-center text-nowrap w-auto">Fecha de registro</th>
                            <!-- <th class="text-end text-nowrap w-auto">Acciones</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($properties as $propiedad)
                        <tr>
                            <td class="text-center text-nowrap">{{ $propiedad->titulo }}</td>

                            <td class="text-center text-nowrap">
                                {{ ucfirst($propiedad->tipo) }}
                            </td>

                            <td class="text-center text-nowrap">{{ $propiedad->barrio }}</td>

                            <td class="text-center text-nowrap">
                                {{ $propiedad->user->name }} <br>
                                <small class="text-muted">{{ $propiedad->user->email }}</small>
                            </td>

                            <td class="text-center text-nowrap">
                                {{ $propiedad->created_at->format('d/m/Y') }}
                            </td>

                            <!-- <td class="text-end text-nowrap">
                                <button class="btn btn-danger btn-sm"
                                    onclick="deleteRecord('/admin/propiedades/{{ $propiedad->id }}/delete')">
                                    <i class="bi bi-trash"></i>
                                    <span class="d-none d-sm-inline">Eliminar</span>
                                </button>
                            </td> -->
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
    const tabla = new DataTable('#tablaPropiedades', {
        order: [],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
        },
        columnDefs: [{
            orderable: false,
            targets: [5]
        }]
    });
    </script>
    @endsection
</x-admin.layout>