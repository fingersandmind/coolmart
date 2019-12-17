<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profile = auth()->user()->profile;

        return view('pages.profile.index', compact('profile'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        return view('pages.profile.edit', compact('profile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileRequest $request, Profile $profile)
    {
        if($request->get('action') == 'profile')
        {
            $request->validated();
            $profile->updateDetails($request);

            return redirect()->route('profile.edit', $profile->id)->withSuccess('Updated successfully!');
        }
    }
}
