<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;

class LinkWooCommerceController extends Controller
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


    public function index(Request $request)
    {
        $user = auth()->user();
        return view('merchant.link.woocommerce.index', compact('user', 'merchantPrograms'));
    }

}
