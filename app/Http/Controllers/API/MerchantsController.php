<?php

namespace App\Http\Controllers\API;

use App\Setting;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use \League\Fractal\Pagination\IlluminatePaginatorAdapter;

use App\Events\Auth\UserRequestedActivationEmail;
use App\Transformers\MerchantTransformer;
use Illuminate\Foundation\Auth\Authenticatesmerchants;
use Illuminate\Validation\Rule;
use jeremykenedy\LaravelRoles\Models\Role;
use Webpatser\Uuid\Uuid;

use App\Models\Merchant;
use App\Models\User;


class MerchantsController extends Controller
{
    const PAGINATE_PER_PAGE = 10;

    public function index(Request $request)
    {
        $query = Merchant::query();
        // if (!auth()->user()->hasRole('admin')){
        //     $query->where('approved','=', true);
        // }
        // $query->where('approved','=', true);


        if($request->has('merchant_category_id')){
            $query->whereHas('programs', function ($subquery) use($request) {
                $subquery->where('program_category_id', $request->query('merchant_category_id'));
            });
        }

        $merchants = $query->paginate(self::PAGINATE_PER_PAGE);
        return fractal()->collection($merchants)
            ->transformWith(new MerchantTransformer)
            ->parseIncludes(['media','programs'])
            ->paginateWith(new IlluminatePaginatorAdapter($merchants));
    }

    public function store(Request $request)
    {
        $auto_approve = Setting::where('key', 'merchant_auto_approve')->first();
        $approve = filter_var($auto_approve->value, FILTER_VALIDATE_BOOLEAN);
        $merchant = new Merchant;
        $merchant->name = $request->name;
        $merchant->uuid = Uuid::generate(4);
        $merchant->user_id = $request->user()->id;
        $merchant->approved = $approve;
        $merchant->merchant_category_id = MerchantCategory::where('slug', 'other')->first()->id;
        $merchant->save();

        return fractal($merchant, new MerchantTransformer)->respond();
    }


    public function show(Merchant $merchant)
    {
        return fractal()->item($merchant)
            ->transformWith(new MerchantTransformer)
            ->parseIncludes('media');
    }

    public function update(Request $request, Merchant $merchant)
    {
        if ($request->has('merchant_reward')){
            if ($request->input('merchant_reward') !== $merchant->merchantReward){
                $merchant->merchantRewards()->create([
                    'percentage' => $request->input('merchant_reward')
                ]);
            }
        }
        $merchant->update($request->all());
        return fractal()->item($merchant)
            ->transformWith(new MerchantTransformer)
            ->parseIncludes('media');
    }

    public function destroy(Request $request, Merchant $merchant)
    {
        $merchant->delete();

        return response()->json([
            'message' => 'User was deleted',
        ]);
    }

}
