<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'short_name'])]
#[Table('Permisos')]

class Permiso extends Model
{
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'rolesypermisos', 'permisos_id', 'role_id');
    }
}
