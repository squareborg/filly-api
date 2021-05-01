<?php

namespace App\Http\Controllers;

use App\Models\ConfirmationToken;
use App\Http\Requests\ProfileUpdateRequest;
use Carbon\Carbon;
use App\Models\User;

use Illuminate\Http\Request;


class UserController extends Controller
{
    public function show(Request $request, User $user)
    {
        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = auth()->user();
        return view('user.edit', compact('user'));
    }

    /**
 * Update the specified resource in storage.
 *
 * @param ProfileUpdateRequest $request
 * @return \Illuminate\Http\Response
 */
    public function update(ProfileUpdateRequest $request)
    {
        $request->user()->update([
            'username' => $request->get('username'),
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'email' => $request->get('email'),
            'date_of_birth' => $request->get('date_of_birth') ? Carbon::createFromFormat('d/m/Y', $request->get('date_of_birth'))->toDateString() : null,
            'gender' => $request->get('gender'),
            'phone' => $request->get('phone'),
            'address_line_1' => $request->get('address_line_1'),
            'address_line_2' => $request->get('address_line_2'),
            'country' => $request->get('country'),
            'postcode' => $request->get('postcode'),
        ]);

        return redirect()->route('user.edit')->with('success', trans('user.profile.updated'));
    }
}
