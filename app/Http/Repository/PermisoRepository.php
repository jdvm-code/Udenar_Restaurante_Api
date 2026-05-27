<?php
namespace App\Http\Repository;

use App\Http\Services\PermisoServices;
use App\Models\Permiso;

class PermisoRepository extends BaseRepository implements PermisoServices {

    public function __construct(private Permiso $model)
    {
        parent::__construct($model);
    }
}