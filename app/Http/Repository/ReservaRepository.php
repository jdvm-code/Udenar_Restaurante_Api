<?php
namespace App\Http\Repository;

use App\Http\Services\ReservaService;
use App\Models\Reserva;

class ReservaRepository extends BaseRepository implements ReservaService {
    public function __construct(private Reserva $model)
    {
        parent::__construct($model);
    }
}