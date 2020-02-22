<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Transformers\SaleTransformer;

class AdminSalesController extends Controller
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
        $sales = Sale::all();
        fractal()->collection($sales, new SaleTransformer())->parseIncludes(['subscription.program', 'subscription.user'])->toArray();
        return view('admin.sales.index', compact('sales'));
    }

}
