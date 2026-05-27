<?php
namespace App\Http\Repository;
use App\Http\Repository\BaseRepository;
use App\Http\Services\RoleServices;
use App\Models\Role;

class RoleRepository extends BaseRepository implements RoleServices {
    
    public function __construct(private Role $model)
    {
        parent::__construct($model);
    }
}