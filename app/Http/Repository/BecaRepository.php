<?php

namespace App\Http\Repository;

use App\Http\Services\BecaService;
use App\Models\Beca;

class BecaRepository extends BaseRepository implements BecaService
{
    public function __construct(private Beca $model)
    {
        parent::__construct($model);
    }

    public function getByUserId($userId)
    {
        $beca = Beca::where('users_id', $userId)->first();

        if (!$beca) {
            return response()->json(['message' => 'No tiene beca asignada'], 404);
        }

        return response()->json($beca);
    }
}
