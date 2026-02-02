<x-admin.layout>
<div class="container">
    <h1>Editar usuario</h1>

    <form method="POST" action="{{ route('user.update', $user->id) }}" class="row g-3 needs-validation" novalidate>
        @csrf
        @method('PUT')

        {{-- Nombre --}}
        <div class="col-md-4">
            <label class="form-label">Nombre</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
        </div>

        {{-- Email --}}
        <div class="col-md-4">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
        </div>

        {{-- Teléfono --}}
        <div class="col-md-4">
            <label class="form-label">Password</label>
            <input type="text" name="password" value="{{ old('password', $user->password) }}" class="form-control">
        </div>


        {{-- Fecha --}}
        <div class="col-md-4">
            <label class="form-label">Fecha</label>
            <input type="date" name="date" value="{{ old('date', $user->date) }}" class="form-control" required>
        </div>

        {{-- Estado --}}
        <div class="col-md-4">
            <label class="form-label">Estado</label>
            <select name="status" class="form-select" required>
                <option value="activo" {{ $user->status=='activo'?'selected':'' }}>Activo</option>
                <option value="inactivo" {{ $user->status=='inactivo'?'selected':'' }}>Inactivo</option>
            </select>
        </div>

        <div class="col-12 mt-3">
            <button type="submit" class="btn btn-success">Guardar cambios</button>
            <a href="{{ route('user.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
</x-admin.layout>
