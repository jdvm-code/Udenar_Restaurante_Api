<?php
namespace App\Http\Repository;
use App\Http\Services\ComidaService;
use App\Models\Comida;

class ComidaRepository extends BaseRepository implements ComidaService {
    public function __construct(private Comida $model)
    {
        parent::__construct($model);
    }
}