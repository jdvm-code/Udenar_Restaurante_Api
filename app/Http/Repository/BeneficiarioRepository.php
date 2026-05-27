<?php
namespace App\Http\Services;

use App\Http\Repository\BaseRepository;
use App\Models\Beneficiario;

class BeneficiarioRepository extends BaseRepository implements BeneficiarioServices {
    public function __construct(private Beneficiario $model)
    {
        parent::__construct($model);
    }
}