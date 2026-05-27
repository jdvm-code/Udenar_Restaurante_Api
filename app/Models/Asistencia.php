<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id','comidas_id', 'fecha_asistencia', 'fecha_registro','codigo', 'estadosAsistencia_id'])]
#[Table('asistencias')]

class Asistencia extends Model
{
    //
}
