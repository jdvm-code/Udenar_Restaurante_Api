<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['becas_id','horarios_id', 'comidas_id','estados_reservas_id','fecha_registro', 'fecha_reserva','codigo'])]
#[Table('reservas')]

class Reserva extends Model
{
    //
}
