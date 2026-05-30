<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'short_name'])]
#[Table('roles')]

class Role extends Model
{
    public function permisos()
    {
        return $this->belongsToMany(Permiso::class, 'rolesypermisos', 'role_id', 'permisos_id');
    }
}
