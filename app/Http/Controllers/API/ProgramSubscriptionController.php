<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use \League\Fractal\Pagination\IlluminatePaginatorAdapter;

use App\Events\Auth\UserRequestedActivationEmail;
use App\Transformers\ProgramTransformer;
use App\Transformers\SubscriptionTransformer;
use Illuminate\Foundation\Auth\AuthenticatesAdverts;
use Illuminate\Validation\Rule;
use jeremykenedy\LaravelRoles\Models\Role;
use Webpatser\Uuid\Uuid;

use App\Models\Program;
use App\Models\User;
use App\Models\Subscription;

class ProgramSubscriptionController extends Controller
{
    const PAGINATE_PER_PAGE = 10;

    public function index(Request $request)
    {
        $subscriptions = Subscription::where('user_id', auth()->user()->id)->paginate(self::PAGINATE_PER_PAGE);

        return fractal()->collection($subscriptions)
            ->transformWith(new SubscriptionTransformer)
            ->parseIncludes(['program'])
            ->paginateWith(new IlluminatePaginatorAdapter($subscriptions));
    }

    public function show(Request $request, Subscription $subscription)
    {
        return fractal()->item($subscription)
            ->transformWith(new SubscriptionTransformer)
            ->parseIncludes(['program']);
    }

    public function destroy(Request $request, Subscription $subscription)
    {
        $subscription->delete();
        return response()->json([
            'message' => 'deleted'
        ], 204);
    }
}
