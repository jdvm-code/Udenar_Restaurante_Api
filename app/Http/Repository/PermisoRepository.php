<?php
namespace App\Http\Repository;

use App\Http\Services\PermisoService;
use App\Models\Permiso;

class PermisoRepository extends BaseRepository implements PermisoService {

    public function __construct(private Permiso $model)
    {
        parent::__construct($model);
    }
}