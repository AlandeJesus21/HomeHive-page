@extends('layouts.app')

{{-- Aseguramos que la variable $habitacion y $id existan y se pasa el objeto completo. --}}
@php
    $id = $habitacion->id ?? 1;
    $currentRoute = Route::currentRouteName();
@endphp

@section('title', $habitacion->titulo ?? 'Reservar Habitación')

@section('content')
    <div class="container mx-auto p-4">
        {{-- Título Principal y Ubicación --}}
        <h1 class="text-3xl font-semibold mb-2">{{ $habitacion->titulo ?? 'Cuarto "Flor de Mayo"' }}</h1>
        <p class="text-xl text-gray-600 mb-6">
            <span class="font-light text-gray-700"> - </span> {{ $habitacion->barrio ?? 'Barrio Guadalupe' }}
        </p>

        {{-- --------------------------------- --}}
        {{-- NAVEGACIÓN DE PESTAÑAS (TABS)     --}}
        {{-- --------------------------------- --}}
        <nav class="flex space-x-4 border-b mb-6">
            <a href="{{ route('habitaciones.show', $id) }}"
               class="pb-2 px-1 font-medium text-lg {{ $currentRoute == 'habitaciones.show' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">Vista general</a>
            <a href="{{ route('habitaciones.detalles', $id) }}"
               class="pb-2 px-1 font-medium text-lg {{ $currentRoute == 'habitaciones.detalles' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">Detalles</a>
            <a href="{{ route('habitaciones.comentarios', $id) }}"
               class="pb-2 px-1 font-medium text-lg {{ $currentRoute == 'habitaciones.comentarios' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">Comentarios</a>
            <a href="{{ route('habitaciones.reservas', $id) }}"
               class="pb-2 px-1 font-medium text-lg {{ $currentRoute == 'habitaciones.reservas' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">Reservar</a>
        </nav>

        {{-- --------------------------------- --}}
        {{-- CONTENIDO PRINCIPAL (3 COLUMNAS)  --}}
        {{-- --------------------------------- --}}
        <div class="flex flex-col md:flex-row gap-8">

            {{-- COLUMNA 1 (IZQUIERDA): GALERÍA DE FOTOS (Se mantiene del original) --}}
            <div class="md:w-1/2 lg:w-5/12">
                <div class="grid grid-cols-2 grid-rows-2 gap-4">
                    <div class="rounded-lg overflow-hidden h-64 shadow-md">
                        <img src="{{ asset('images/cuarto 1.png') }}" alt="Foto 1 de la habitación" class="w-full h-full object-cover transition duration-300 hover:scale-105">
                    </div>
                    <div class="rounded-lg overflow-hidden h-64 shadow-md">
                        <img src="{{ asset('images/cuarto 2.png') }}" alt="Foto 2 de la habitación" class="w-full h-full object-cover transition duration-300 hover:scale-105">
                    </div>
                    <div class="rounded-lg overflow-hidden h-64 shadow-md">
                        <img src="{{ asset('images/Cuarto 3.png') }}" alt="Foto 3 de la habitación" class="w-full h-full object-cover transition duration-300 hover:scale-105">
                    </div>
                    <div class="rounded-lg overflow-hidden h-64 shadow-md">
                        <img src="{{ asset('images/Cuarto 4.png') }}" alt="Foto 4 de la habitación" class="w-full h-full object-cover transition duration-300 hover:scale-105">
                    </div>
                </div>
            </div>

            {{-- COLUMNA 2 (CENTRO): TARJETA DE PROPIETARIO/DETALLES --}}
            <div class="md:w-1/4 lg:w-3/12">
                <div class="bg-white p-6 border border-gray-200 rounded-lg shadow-lg h-full">

                    {{-- Propietario/Usuario --}}
                    <div class="flex items-center mb-4 pb-4 border-b">
                        <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold text-xl mr-3">
                            A
                        </div>
                        <span class="font-semibold text-gray-800">Alexis Gomez</span>
                    </div>

                    {{-- Calificación --}}
                    <div class="flex items-center mb-2">
                        <span class="text-lg font-bold mr-1">{{ number_format($habitacion->calificacion ?? 5.0, 1) }}</span>
                        <span class="text-xl text-yellow-500">★★★★★</span>
                    </div>

                    {{-- Detalles Clave --}}
                    <dl class="space-y-1 text-gray-700 text-sm">
                        <div><dt class="font-semibold inline">Precio (por día):</dt> <dd class="inline">${{ number_format($habitacion->precio ?? 1230, 0, ',', '.') }}</dd></div>
                        <div><dt class="font-semibold inline">Barrio:</dt> <dd class="inline">{{ $habitacion->barrio ?? 'Barrio Guadalupe' }}</dd></div>
                        <div><dt class="font-semibold inline">Calle:</dt> <dd class="inline">{{ $habitacion->calle ?? '11A Ote Sur' }}</dd></div>
                        <div><dt class="font-semibold inline">Tipo de pago:</dt> <dd class="inline">{{ $habitacion->tipo_pago ?? 'Transferencia' }}</dd></div>
                    </dl>
                </div>
            </div>

            {{-- COLUMNA 3 (DERECHA): TARJETA DE RESERVACIÓN (Formulario corregido) --}}
            <div class="md:w-1/4 lg:w-4/12">
                <div class="bg-white p-6 border border-gray-200 rounded-lg shadow-lg sticky top-4">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 text-center border-b pb-2">Confirmar Reservación</h2>

                    {{-- CORRECCIÓN: Usar POST y enctype para subir archivos --}}
                    <form method="POST" action="{{ route('habitaciones.reservas', $id) }}" enctype="multipart/form-data">
                        @csrf

                        {{-- Fecha de inicio --}}
                        <div class="mb-3">
                            <label for="fecha_inicio" class="text-sm text-gray-700 block font-medium">Fecha de inicio:</label>
                            <input type="date" name="fecha_inicio" id="fecha_inicio" required
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm p-2 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        {{-- Fecha de finalización --}}
                        <div class="mb-3">
                            <label for="fecha_fin" class="text-sm text-gray-700 block font-medium">Fecha de finalización:</label>
                            <input type="date" name="fecha_fin" id="fecha_fin" required
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm p-2 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        {{-- Precio a pagar (Visualmente atractivo) --}}
                        <div class="mb-3 p-3 bg-gray-50 rounded-md border border-gray-200 flex justify-between items-center">
                            <label class="text-sm text-gray-700 font-medium">Precio por día:</label>
                            <span class="text-lg font-bold text-green-600">${{ number_format($habitacion->precio ?? 1230, 0, ',', '.') }}</span>
                            <input type="hidden" name="precio_diario" value="{{ $habitacion->precio ?? 1230 }}">
                        </div>

                        {{-- Comprobante de pago (Input File Mejorado con JS) --}}
                        <div class="mb-3">
                            <label for="comprobante" class="text-sm text-gray-700 block font-medium mb-1">Comprobante de pago:</label>
                            
                            {{-- Botón Estilizado para subir archivo --}}
                            <div class="flex items-center justify-between p-2 border border-gray-300 rounded-md bg-white cursor-pointer hover:bg-gray-50 transition" onclick="document.getElementById('comprobante_input').click()">
                                <span id="file_name_display" class="text-sm text-gray-500 truncate">Haga clic para subir (JPG/JPEG)</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L6.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            
                            {{-- Input de archivo real, oculto --}}
                            <input type="file" name="comprobante" id="comprobante_input" accept=".jpg,.jpeg" class="hidden" required>
                        </div>
                        
                        {{-- Cuantas personas --}}
                        <div class="mb-3">
                            <label for="personas" class="text-sm text-gray-700 block font-medium">Número de personas:</label>
                            <input type="number" name="personas" id="personas" min="1" required value="1"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm p-2 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        {{-- Mascotas --}}
                        <div class="mb-5">
                            <label for="mascotas" class="text-sm text-gray-700 block font-medium">Mascotas (opcional):</label>
                            <input type="text" name="mascotas" id="mascotas" placeholder="Número o tipo de mascotas"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm p-2 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        {{-- Botón de Reservar (Ahora negro como solicitaste) --}}
                        <button type="submit"
                                class="w-full bg-gray-800 hover:bg-black text-white font-bold py-3 rounded-lg transition duration-300 shadow-xl text-lg">
                            Confirmar Reserva
                        </button>
                    </form>

                </div>
            </div>
            {{-- FIN COLUMNA DERECHA --}}

        </div>
        {{-- FIN CONTENIDO PRINCIPAL --}}
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const comprobanteInput = document.getElementById('comprobante_input');
        const fileNameDisplay = document.getElementById('file_name_display');
        
        // Listener para actualizar el nombre del archivo
        comprobanteInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                // Muestra el nombre del archivo seleccionado
                fileNameDisplay.textContent = this.files[0].name;
                fileNameDisplay.classList.remove('text-gray-500');
                fileNameDisplay.classList.add('text-gray-800', 'font-semibold');
            } else {
                // Si se cancela la selección
                fileNameDisplay.textContent = 'Haga clic para subir (JPG/JPEG)';
                fileNameDisplay.classList.add('text-gray-500');
                fileNameDisplay.classList.remove('text-gray-800', 'font-semibold');
            }
        });
        
        // Asegura que el input de personas tenga valor inicial
        const personasInput = document.getElementById('personas');
        if (!personasInput.value) {
            personasInput.value = 1;
        }
    });
</script>
@endpush
