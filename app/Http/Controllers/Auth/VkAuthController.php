<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Laravel\Socialite\Facades\Socialite;

class VkAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('vkontakte')->redirect();
    }

    public function callback()
    {
        $vkUser = Socialite::driver('vkontakte')->user();

        $user = User::updateOrCreate(
            ['vk_id' => $vkUser->getId()],
            [
                'name' => $vkUser->getName(),
                'email' => $vkUser->getEmail() ?? null,
                'password' => bcrypt(uniqid()),
            ]
        );

        FacadesAuth::login($user);

        return redirect('/dashboard');
    }
}
