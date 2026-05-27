<?php
namespace App\Http\Repository;

use App\Http\Services\AsistenciaServices;
use App\Models\Asistencia;

class AsistenciaRepository extends BaseRepository implements AsistenciaServices {
    public function __construct(private Asistencia $model)
    {
        parent::__construct($model);
    }
}