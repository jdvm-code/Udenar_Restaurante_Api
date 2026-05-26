<?php
namespace App\Repository;

use App\Http\Repository\BaseRepository;
use App\Models\EstadoAsistencia;
use App\Services\EstadoAsistenciaService;

class EstadoAsistenciaRepository extends BaseRepository implements EstadoAsistenciaService
{
    public function __construct(private EstadoAsistencia $model)
    {
        parent::__construct($model);
    }
}