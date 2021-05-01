<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\User;

class AffiliateProgramController extends Controller
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
     * Show the affiliate subscribed program.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */

    public function __invoke(Request $request, Subscription $subscription)
    {
        return view('affiliate.programs.show', compact('subscription'));
    }

}
