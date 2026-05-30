<?php
namespace App\Http\Repository;

use App\Http\Services\EstadoBecaService;
use App\Models\EstadoBeca;

class EstadoBecaRepository extends BaseRepository implements EstadoBecaService {
    public function __construct(private EstadoBeca $model)
    {
        parent::__construct($model);
    }
}