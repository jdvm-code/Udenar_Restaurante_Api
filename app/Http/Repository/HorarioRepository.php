<?php
namespace App\Http\Repository;

use App\Http\Services\HorarioService;
use App\Models\Horario;

class HorarioRepository extends BaseRepository implements HorarioService{
    public function __construct(private Horario $model)
    {
        parent::__construct($model);
    }
}