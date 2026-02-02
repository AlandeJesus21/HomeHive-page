<x-admin.layout>
    <div class="container">
        <h2 class="mt-4 mb-3 fw-bold text-center">Editar Propiedad</h2>

        <form method="POST" action="{{ route('properties.update', $propiedad->id) }}" enctype="multipart/form-data"
            class="row g-3 needs-validation" novalidate>
            @csrf
            @method('PUT')

            {{-- Título --}}
            <div class="col-md-6">
                <label class="form-label">Título</label>
                <input type="text" name="titulo" value="{{ old('titulo', $propiedad->titulo) }}" class="form-control"
                    required>
            </div>

            {{-- Tipo --}}
            <div class="col-md-6">
                <label class="form-label">Tipo</label>
                <select name="tipo" class="form-select" required>
                    <option value="Departamento" {{ $propiedad->tipo == 'Departamento' ? 'selected' : '' }}>Departamento
                    </option>
                    <option value="Casa" {{ $propiedad->tipo == 'Casa' ? 'selected' : '' }}>Casa</option>
                </select>
            </div>

            {{-- Barrio --}}
            <div class="col-md-4">
                <label class="form-label">Barrio</label>
                <input type="text" name="barrio" value="{{ old('barrio', $propiedad->barrio) }}"
                    class="form-control" required>
            </div>

            {{-- Calle --}}
            <div class="col-md-4">
                <label class="form-label">Calle</label>
                <input type="text" name="calle" value="{{ old('calle', $propiedad->calle) }}" class="form-control"
                    required>
            </div>

            {{-- Número de Calle --}}
            <div class="col-md-4">
                <label class="form-label">Número</label>
                <input type="text" name="numero_calle" value="{{ old('numero_calle', $propiedad->numero_calle) }}"
                    class="form-control" required>
            </div>

            {{-- Precio --}}
            <div class="col-md-6">
                <label class="form-label">Precio</label>
                <input type="number" name="precio" value="{{ old('precio', $propiedad->precio) }}"
                    class="form-control" required>
            </div>

            {{-- Imagen --}}
            <div class="col-md-6">
                <label class="form-label">Imagen</label>
                <input type="file" name="imagen" class="form-control">
                @if ($propiedad->imagen)
                    <img src="{{ asset('storage/' . $propiedad->imagen) }}" alt="Imagen propiedad"
                        class="img-thumbnail mt-2" width="150">
                @endif
            </div>



            {{-- Estatus (solo para Admin) --}}
            @if (auth()->user()->rol === 'admin')
                <div class="col-md-6">
                    <label class="form-label">Estatus</label>
                    <select name="estatus" class="form-select">
                        <option value="activo" {{ $propiedad->estatus == 'activo' ? 'selected' : '' }}>Activo</option>
                        <option value="inactivo" {{ $propiedad->estatus == 'inactivo' ? 'selected' : '' }}>Inactivo
                        </option>
                    </select>
                </div>
            @endif


            {{-- Botones --}}
            <div class="col-12 mt-3">
                <button type="submit" class="btn btn-success">Guardar cambios</button>
                <a href="{{ route('properties.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>



        </form>
    </div>
</x-admin.layout>
