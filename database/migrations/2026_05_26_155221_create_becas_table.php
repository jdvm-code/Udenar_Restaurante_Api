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
        Schema::create('becas', function (Blueprint $table) {
            $table->id();
            // Apesta a la convención singular 'users_id', mapeamos explícitamente a la tabla 'users'
            $table->foreignId('users_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->foreignId('estados_becas_id')->constrained('estados_becas')->onDelete('restrict')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('becas');
    }
};
