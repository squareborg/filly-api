<?php

namespace App\Transformers;

use App\Models\ProgramCategory;

class ProgramCategoryTransformer extends \League\Fractal\TransformerAbstract
{

    public function transform(ProgramCategory $programCategory)
    {
        return $programCategory->toArray();
    }
}
