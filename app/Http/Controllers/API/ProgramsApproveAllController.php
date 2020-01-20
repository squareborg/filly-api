<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use \League\Fractal\Pagination\IlluminatePaginatorAdapter;

use App\Events\Auth\UserRequestedActivationEmail;
use App\Transformers\ProgramTransformer;
use Illuminate\Foundation\Auth\Authenticatesprograms;

use App\Models\Program;


class ProgramsApproveAllController extends Controller
{

    public function __invoke()
    {
        Program::where([
            'approved' => false,
            'rejected' => false
        ])->update(['approved' => true]);
        $programs = Program::where([
            'approved' => false,
            'rejected' => false
        ])->get();
        return fractal()->collection($programs)
            ->transformWith(new ProgramTransformer);
    }

}
