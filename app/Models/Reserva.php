<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

#[Fillable(['becas_id', 'horarios_id', 'comidas_id', 'estados_reservas_id', 'fecha_registro', 'fecha_reserva', 'codigo'])]
#[Table('reservas')]

class Reserva extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($reserva) {
            $reserva->codigo = (string) Str::uuid();
        });
    }

    public function beca()
    {
        // 'becas_id' es la columna en tu tabla 'reservas'
        return $this->belongsTo(Beca::class, 'becas_id');
    }

    // Relación con Horario
    public function horario()
    {
        return $this->belongsTo(Horario::class, 'horarios_id');
    }

    // Relación con Comida
    public function comida()
    {
        return $this->belongsTo(Comida::class, 'comidas_id');
    }

    // Relación con EstadoReserva
    public function estadoReserva()
    {
        return $this->belongsTo(EstadoReserva::class, 'estados_reservas_id');
    }

    //usuario

}
