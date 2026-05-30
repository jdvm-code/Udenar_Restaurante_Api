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
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('becas_id')->constrained('becas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('horarios_id')->constrained('horarios')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('comidas_id')->constrained('comidas')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('estados_reservas_id')->constrained('estados_reservas')->onDelete('restrict')->onUpdate('cascade');
            $table->dateTime('fecha_registro');
            $table->date('fecha_reserva');
            $table->string('codigo', 64)->unique();

            // Restricción única compuesta para evitar duplicar el mismo tipo de comida por día
            $table->unique(['becas_id', 'fecha_reserva', 'comidas_id'], 'unique_estudiante_comida_dia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
