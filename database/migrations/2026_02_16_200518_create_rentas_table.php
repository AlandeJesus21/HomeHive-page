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
        Schema::create('rentas', function (Blueprint $table) {
            // Relación con la propiedad
            $table->foreignId('propiedad_id')->constrained('propiedads')->onDelete('cascade');
            
            // Relación con el inquilino (usuario que paga)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Relación con el arrendador (dueño de la propiedad)
            $table->unsignedBigInteger('arrendador_id');
            $table->foreign('arrendador_id')->references('id')->on('users')->onDelete('cascade');
            
            // Datos de la renta
            $table->decimal('monto', 10, 2);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            
            // Opcional: Para guardar el ID de pago de Stripe por seguridad
            $table->string('stripe_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentas');
    }
};
