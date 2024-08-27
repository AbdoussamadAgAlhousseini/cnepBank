<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgentAuthController extends Controller
{


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('agent')->attempt($credentials, $request->filled('remember'))) {
            return redirect()->intended(route('agent.home'));
        }

        return redirect()->back()->withErrors(['email' => 'The provided credentials do not match our records.']);
    }
    public function showLoginForm()
    {
        return view('auth.agent-login');
    }



    // {
    //     $credentials = $request->only('email', 'password');
    //     if (Auth::guard('agent')->attempt($credentials, $request->filled('remember'))) {
    //         return redirect()->intended(route('agent.home'));
    //     }

    //     return back()->withErrors([
    //         'email' => 'The provided credentials do not match our records.',
    //     ]);
    // }




    public function logout(Request $request)
    {
        Auth::guard('agent')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('agent.login');
    }
}
