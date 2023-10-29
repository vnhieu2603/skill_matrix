<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function SocialSignup($provider)
    {
        // Socialite will pick response data automatic 
        $user = Socialite::driver($provider)->user();

        return response()->json($user);
    }
}
