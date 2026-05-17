<?php

namespace App\Http\Controllers\Auth;

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
        return Socialite::driver('vkontakte')->scopes(['email'])->redirect();
    }

    public function callback()
    {
        $vkUser = Socialite::driver('vkontakte')->stateless()->user();

        $user = User::updateOrCreate(
            ['vk_id' => $vkUser->getId()],
            [
                'first_name' => $vkUser->getName() ?: 'Пользователь VK',
                'email' => $vkUser->getEmail() ?? null,
                'password' => bcrypt(uniqid()),
            ]
        );

        FacadesAuth::login($user);

        return redirect('/dashboard');
    }
}
