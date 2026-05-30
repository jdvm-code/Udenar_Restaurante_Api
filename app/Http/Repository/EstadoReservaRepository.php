<?php
namespace App\Http\Repository;

use App\Http\Repository\BaseRepository;
use App\Http\Services\EstadoReservaService;
use App\Models\EstadoReserva;

class EstadoReservaRepository extends BaseRepository implements EstadoReservaService
{
    public function __construct(private EstadoReserva $model)
    {
        parent::__construct($model);
    }
}