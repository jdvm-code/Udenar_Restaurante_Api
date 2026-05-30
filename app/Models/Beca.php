<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['fecha_inicio', 'fecha_fin', 'estados_becas_id', 'users_id'])]
#[Table('becas')]


class Beca extends Model
{
    //
}
