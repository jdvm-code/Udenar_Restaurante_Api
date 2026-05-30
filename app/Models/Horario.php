<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['dia', 'hora_inicio', 'hora_fin', 'cupo'])]
#[Table('horarios')]

class horario extends Model
{
    //
}
