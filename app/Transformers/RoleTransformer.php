<?php

namespace App\Transformers;

use Spatie\Permission\Models\Role;

class RoleTransformer extends \League\Fractal\TransformerAbstract
{
    public function transform(Role $role)
    {
        return $role->toArray();
    }

}