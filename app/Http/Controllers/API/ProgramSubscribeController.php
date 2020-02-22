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
use Illuminate\Foundation\Auth\AuthenticatesAdverts;
use Illuminate\Validation\Rule;
use jeremykenedy\LaravelRoles\Models\Role;
use Webpatser\Uuid\Uuid;

use App\Models\Program;
use App\Models\User;
use App\Models\Subscription;

class ProgramSubscribeController extends Controller
{
    public function __invoke(Request $request, Program $program)
    {
        $subscription = Subscription::onlyTrashed()->where(
            [
                'user_id' => $request->user()->id,
                'program_uuid' => $program->uuid
            ]
        );

        if ($subscription->count() > 0){
            $subscription->restore();
        }
        else{
            $subscription = Subscription::where(
                [
                    'user_id' => $request->user()->id,
                    'program_uuid' => $program->uuid
                ]
            );
            if ($subscription->count() == 0){
                $subscription = Subscription::create(
                    [
                        'user_id' => $request->user()->id,
                        'program_uuid' => $program->uuid
                    ]
                );
            }

        }

        return response()->json([$subscription,
            'message' => 'Subscribed'
        ], 200);
    }
}
