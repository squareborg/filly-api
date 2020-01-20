<?php

namespace App\Transformers;

use App\Models\User;

class UserTransformer extends \League\Fractal\TransformerAbstract
{
    protected $availableIncludes = ['roles', 'merchant','affiliate_stats'];

    public function transform(User $user)
    {
        return $user->toArray();
    }

    // public function includeProfile(User $user)
    // {
    //     if ($user->profile){
    //         return $this->item($user->profile, new ProfileTransformer);
    //     }
    // }

    // public function includePermissions(User $user)
    // {
    //     $permissions = $user->getPermissions();

    //     return $this->collection($permissions, new UserPermissionsTransformer);
    // }

    public function includeRoles(User $user)
    {
        $roles = $user->roles;

        return $this->collection($roles, new RoleTransformer);
    }

    public function includeMerchant(User $user)
    {
        if ($user->merchant()){
            return $this->item($user->getMerchantProfile(), new MerchantTransformer);
        }
    }

    public function includeAffiliateStats(User $user)
    {
        return $this->primitive([
            'clicks' => $user->clicks,
            'sales' => $user->salesCount,
        ]);
    }
}
