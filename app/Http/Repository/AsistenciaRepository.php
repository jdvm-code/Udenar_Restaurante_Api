<?php
namespace App\Http\Repository;

use App\Http\Services\AsistenciaService;
use App\Models\Asistencia;

class AsistenciaRepository extends BaseRepository implements AsistenciaService {
    public function __construct(private Asistencia $model)
    {
        parent::__construct($model);
    }
}