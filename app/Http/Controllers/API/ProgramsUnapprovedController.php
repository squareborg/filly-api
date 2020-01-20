<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use \League\Fractal\Pagination\IlluminatePaginatorAdapter;

use App\Events\Auth\UserRequestedActivationEmail;
use App\Transformers\ProgramTransformer;
use Illuminate\Foundation\Auth\Authenticatesprograms;

use App\Models\Program;


class ProgramsUnapprovedController extends Controller
{
    const PAGINATE_PER_PAGE = 10;

    public function __invoke()
    {
        $programs = Program::where([
            'approved' => false,
            'rejected' => false
        ])->paginate(self::PAGINATE_PER_PAGE);

        return fractal()->collection($programs)
            ->transformWith(new ProgramTransformer)
            ->paginateWith(new IlluminatePaginatorAdapter($programs));
    }

}
