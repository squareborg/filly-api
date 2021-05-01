<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Transformers\ProgramCategoryTransformer;
use App\Models\ProgramCategory;


class ProgramCategoriesController extends Controller
{
    const PAGINATE_PER_PAGE = 10;

    public function __invoke()
    {
        return fractal()->collection(ProgramCategory::all())
            ->transformWith(new ProgramCategoryTransformer());
    }

}
