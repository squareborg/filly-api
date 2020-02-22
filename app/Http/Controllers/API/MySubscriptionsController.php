<?php

namespace App\Http\Controllers\API;

use App\Transformers\SubscriptionTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class MySubscriptionsController extends Controller
{
    public function __invoke(Request $request)
    {
        $mySubscriptions = $request->user()->subscriptions;
        return fractal()->collection($mySubscriptions)
            ->transformWith(new SubscriptionTransformer())
            ->parseIncludes(['program']);
    }

}
