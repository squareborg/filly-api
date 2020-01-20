<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ProgramCategory;


class AdminCategoriesController extends Controller
{
    public function index(Request $request)
    {
        $categories = ProgramCategory::orderBy('name')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function edit(Request $request, ProgramCategory $programCategory)
    {
        return view('admin.categories.edit', compact('programCategory'));
    }

    public function update(Request $request, ProgramCategory $programCategory)
    {
        $programCategory->update($request->input());
        return redirect(route('admin.categories.index'));
    }

    public function store(Request $request)
    {
        ProgramCategory::create($request->input());
        return redirect(route('admin.categories.index'));
    }

    public function destroy(Request $request, ProgramCategory $programCategory)
    {
        $programCategory->delete();
        return redirect(route('admin.categories.index'));
    }
}
