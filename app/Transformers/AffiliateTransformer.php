<?php

namespace App\Transformers;

use App\Models\User;

class AffiliateTransformer extends \League\Fractal\TransformerAbstract
{

    public function transform(User $affiliate)
    {
        return $affiliate->toArray();
    }
}
