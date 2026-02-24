<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('propiedads', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 50);
            $table->string('tipo', 50);
            $table->string('barrio', 50);
            $table->string('calle', 50);
             $table->decimal('latitud', 10, 7);
            $table->decimal('longitud', 10, 7);
            $table->decimal('precio', 9, 2);
            $table->string('forma_pago', 20);
            $table->string('servicio', 100);
            $table->string('reglas', 100);
            $table->string('cercanias', 100);
            $table->text('descripcion')->nullable();
            $table->string('imagen')->nullable();
            $table->string('status')->default('libre');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('propiedads');
    }
};