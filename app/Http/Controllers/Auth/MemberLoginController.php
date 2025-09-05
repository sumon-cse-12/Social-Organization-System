<?php

namespace App\Http\Controllers\Auth;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberLoginController extends Controller
{
    public function showLoginForm()
    {
        return Inertia::render('Member/Auth/Login',[
        'loginUrl' => route('member.login'),
        'registerUrl' => route('member.register'),
        ]);
    }

    public function login(Request $request)
    {
        // dd($request->all());

        $credentials = $request->only('email', 'password');
        // dd($credentials);

        if (auth()->guard('member')->attempt($credentials)) {

            $request->session()->regenerate();
            return Inertia::location(route('member.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }

    public function logout(Request $request)
    {
        auth()->guard('member')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(['message' => 'Logged out']);
    }
}
