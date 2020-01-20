<?php

namespace App\Http\Controllers;

use \League\Fractal\Pagination\IlluminatePaginatorAdapter;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Program;
use App\Models\Merchant;
use App\Models\ProgramCategory;
use App\Transformers\SubscriptionTransformer;
use App\Transformers\ProgramTransformer;
use App\Transformers\ProgramCategoryTransformer;
use App\Transformers\MerchantTransformer;

class AffiliateController extends Controller
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
        $user = Auth::user();
        $mySubscriptions = $user->subscriptions;
        $mySubscriptions =  fractal()->collection($mySubscriptions)
            ->transformWith(new SubscriptionTransformer())
            ->parseIncludes(['program'])->toArray()['data'];

        $thePrograms = Program::available()->paginate(10);
        $programs = fractal()->collection($thePrograms)
            ->transformWith(new ProgramTransformer())
            ->parseIncludes(['media'])
            ->paginateWith(new IlluminatePaginatorAdapter($thePrograms))
            ->toArray()['data'];


        $theMerchants = Merchant::paginate(100);
        $merchants = fractal()->collection($theMerchants)
            ->transformWith(new MerchantTransformer())
            ->parseIncludes(['media'])
            ->paginateWith(new IlluminatePaginatorAdapter($theMerchants))
            ->toArray()['data'];

        $programCategories = fractal()->collection(ProgramCategory::all())
            ->transformWith(new ProgramCategoryTransformer())
            ->toArray()['data'];

        return view('affiliate.home', compact('user','mySubscriptions', 'programs', 'programCategories', 'merchants'));
    }

}
