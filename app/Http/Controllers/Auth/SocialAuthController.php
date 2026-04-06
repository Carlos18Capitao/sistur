<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        if ($user) {
            if (! $user->google_id) {
                $user->update(['google_id' => $googleUser->getId()]);
            }
            if (! $user->avatar && $googleUser->getAvatar()) {
                $user->update(['avatar' => $googleUser->getAvatar()]);
            }
        } else {
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'email_verified_at' => now(),
            ]);
        }

        Auth::login($user, remember: true);

        return redirect()->intended(route('home'));
    }
}
