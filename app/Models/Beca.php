<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['fecha_inicio', 'fecha_fin', 'estados_becas_id', 'users_id'])]
#[Table('becas')]


class Beca extends Model
{
     // Relación con Usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    // Relación con Reservas
    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'becas_id');
    }


    // Relación con EstadoBeca (o como se llame tu modelo)
    public function estadoBeca()
    {
        return $this->belongsTo(EstadoBeca::class, 'estados_becas_id');
    }
    
}
