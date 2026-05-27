<?php
namespace App\Http\Repository;

use App\Http\Services\BeneficiarioService;
use App\Models\Beneficiario;

class BeneficiarioRepository extends BaseRepository implements BeneficiarioService {
    public function __construct(private Beneficiario $model)
    {
        parent::__construct($model);
    }
}