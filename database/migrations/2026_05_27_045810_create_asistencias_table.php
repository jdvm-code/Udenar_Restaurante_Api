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
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('comidas_id');
            $table->date('fecha_asistencia');
            $table->date('fecha_registro');
            $table->string('codigo');
            $table->unsignedBigInteger('estadosAsistencia_id');



            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('comidas_id')->references('id')->on('comidas')->onDelete('cascade');
            $table->foreign('estadosAsistencia_id')->references('id')->on('estados_asistencia')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
