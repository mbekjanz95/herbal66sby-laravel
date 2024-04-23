<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;


class SocialiteController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request): RedirectResponse
    {
        $user = Socialite::driver('google')->stateless()->user();
        $credentials = ['email' => $user->getEmail()];
        $email  = $user->getEmail();
        $nama_lengkap  = $user->getName();
        $existingUser = Customer::where('email', $email)->first();

        if ($existingUser)
        {
            Auth::login($existingUser);
            $request->session()->regenerate();
            return redirect()->intended('/home');
        }

        //     Customer::create([
        //         'email' =>     $user->getEmail(),
        //         'nama_lengkap' =>   $user->getName()
        //     ]);
        
        return redirect()
        ->route('page-daftar')
        ->with([
            'email' => $email,
            'nama_lengkap' => $nama_lengkap,
            'alert' => [
                'message' => 'Silahkan lengkapi data terlebih dahulu !'
            ]
        ]);
    }
}
