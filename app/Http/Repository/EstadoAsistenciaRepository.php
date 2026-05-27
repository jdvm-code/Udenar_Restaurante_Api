<?php
namespace App\Http\Repository;

use App\Http\Repository\BaseRepository;
use App\Http\Services\EstadoAsistenciaService;
use App\Models\EstadoAsistencia;

class EstadoAsistenciaRepository extends BaseRepository implements EstadoAsistenciaService
{
    public function __construct(private EstadoAsistencia $model)
    {
        parent::__construct($model);
    }
}