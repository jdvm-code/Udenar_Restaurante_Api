<?php
namespace App\Http\Repository;

use App\Http\Services\BecaService;
use App\Models\Beca;

class BecaRepository extends BaseRepository implements BecaService {
    public function __construct(private Beca $model)
    {
        parent::__construct($model);
    }
}