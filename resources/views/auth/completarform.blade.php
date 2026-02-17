<x-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Completar registro con Google
                    </div>

                    <div class="card-body">

                        <form method="POST" action="/save">
                            @csrf

                            <div class="row mb-3">
                                <label class="col-md-4 col-form-label text-md-end">
                                    Selecciona tu rol
                                </label>

                                <div class="col-md-6">
                                    <select name="rol" class="form-control" required>
                                        <option value=""> Seleccionar</option>
                                        <option value="arrendador">Arrendador</option>
                                        <option value="inquilino">Inquilino</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-md-4 col-form-label text-md-end">
                                    Contraseña
                                </label>

                                <div class="col-md-6">
                                    <input type="password" name="password" class="form-control" placeholder="Contraseña"
                                        required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-md-4 col-form-label text-md-end">
                                    Confirmar contraseña
                                </label>

                                <div class="col-md-6">
                                    <input type="password" name="password_confirmation" class="form-control"
                                        placeholder="Confirmar contraseña" required>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Finalizar registro
                                    </button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>