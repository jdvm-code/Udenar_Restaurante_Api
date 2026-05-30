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

        // Se ejecuta automáticamente justo antes de crear el registro
        static::creating(function ($reserva) {
            $reserva->codigo = (string) Str::uuid();
        });
    }

    public function becas()
    {
        // 'becas_id' es la columna en tu tabla 'reservas'
        return $this->belongsTo(Beca::class, 'becas_id');
    }
}
