<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;

class ProgramController extends Controller
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
     * show the create advert view.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */

    public function create(Request $request)
    {
        return view('merchant.programs.create');
    }

    public function edit(Request $request, Program $program)
    {
        return view('merchant.programs.edit', $program);
    }

}
