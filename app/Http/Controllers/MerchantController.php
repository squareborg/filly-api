<?php

namespace App\Http\Controllers;

use \League\Fractal\Pagination\IlluminatePaginatorAdapter;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Program;
use App\Transformers\MerchantTransformer;
use App\Transformers\ProgramTransformer;

class MerchantController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the admin dashboard.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $user = auth()->user();
        $merchant = $user->getMerchantProfile();
        $thePrograms = Program::where('merchant_id', $merchant->id)->paginate(10);
        $merchantPrograms = fractal()->collection($thePrograms)
            ->transformWith(new ProgramTransformer())
            ->parseIncludes(['media'])
            ->paginateWith(new IlluminatePaginatorAdapter($thePrograms))
            ->toArray()['data'];
        $merchant = fractal()->item($merchant, new MerchantTransformer())->toArray()['data'];
        return view('merchant.home', compact('user', 'merchantPrograms', 'merchant'));
    }

}
