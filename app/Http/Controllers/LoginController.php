<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\Customer;

class LoginController extends Controller
{
    public function index()
    {
        return view ('login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) 
        {
            $request->session()->regenerate();
 
            return redirect()->intended('/home');
            // redirect()->intended('/home');
            // $response = response(auth()->user()->username);
            // $response->withCookie('john', auth()->user()->username, 5);
            // return $response;
        }
 
        return back()->withErrors([
            'email' => 'Email/password salah',
        ])->onlyInput('email');
    }
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();    
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return redirect('home');
    }
}
