<?php

namespace App\Http\Controllers\API;

use App\Models\Program;
use App\Transformers\ProgramTransformer;
use \League\Fractal\Pagination\IlluminatePaginatorAdapter;

use App\Transformers\SubscriptionTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class MyProgramsController extends Controller
{
    public function __invoke(Request $request)
    {
        return fractal()->collection($request->user()->merchant->programs()->paginate())
            ->transformWith(new ProgramTransformer())
            ->parseIncludes(['media'])
            ->paginateWith(new IlluminatePaginatorAdapter($request->user()->merchant->programs()->paginate()));
    }

}
