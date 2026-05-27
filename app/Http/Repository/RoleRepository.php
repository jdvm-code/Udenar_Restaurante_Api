<?php
namespace App\Http\Repository;
use App\Http\Repository\BaseRepository;
use App\Http\Services\RoleService;
use App\Models\Role;

class RoleRepository extends BaseRepository implements RoleService {
    
    public function __construct(private Role $model)
    {
        parent::__construct($model);
    }
}