<?php
namespace App\Http\Repository;

use App\Http\Services\BeneficiarioServices;
use App\Models\Beneficiario;

class BeneficiarioRepository extends BaseRepository implements BeneficiarioServices {
    public function __construct(private Beneficiario $model)
    {
        parent::__construct($model);
    }
}