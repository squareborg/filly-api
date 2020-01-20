<?php

namespace App\Http\Controllers;

use App\Video;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('dashboard.index');
    }
}
