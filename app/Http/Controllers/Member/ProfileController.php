<?php

namespace App\Http\Controllers\Member;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
   public function index()
{
    $member = Auth::guard('member')->user();

    if (!$member) {
        return redirect()->route('member.login');
    }

    return Inertia::render('Member/Profile/Show', [
        'member' => $member,
        'editUrl' => route('member.profile.edit'),
    ]);
}


    public function edit()
    {
        $member = Auth::guard('member')->user();

        if (!$member) {
            return redirect()->route('member.login');
        }

        return Inertia::render('Member/Profile/Edit', [
            'member' => $member,
        ]);
    }

    public function update(Request $request)
    {
        $member = Auth::guard('member')->user();

        if (!$member) {
            return redirect()->route('member.login');
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email,' . $member->id,
            // Add other fields as necessary
        ]);

        $member->update($validatedData);

        return redirect()->route('member.profile')->with('success', 'Profile updated successfully.');
    }
}
