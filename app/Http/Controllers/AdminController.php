<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('admin.home');
    }
}
