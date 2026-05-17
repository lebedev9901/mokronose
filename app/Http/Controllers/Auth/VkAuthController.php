<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;

class VkAuthController extends Controller
{
    public function redirect()
    {
        $query = http_build_query([
            'client_id' => config('services.vkontakte.client_id'),
            'redirect_uri' => config('services.vkontakte.redirect'),
            'scope' => 'email',
            'response_type' => 'code',
            'v' => '5.131',
        ]);

        return redirect('https://oauth.vk.com/authorize?' . $query);
    }

    public function callback()
    {

        dd(request()->all());

        if (request()->has('error')) {
            return redirect('/login')->withErrors([
                'vk' => request('error_description', 'Ошибка авторизации VK'),
            ]);
        }

        $tokenResponse = Http::get('https://oauth.vk.com/access_token', [
            'client_id' => config('services.vkontakte.client_id'),
            'client_secret' => config('services.vkontakte.client_secret'),
            'redirect_uri' => config('services.vkontakte.redirect'),
            'code' => request('code'),
        ])->json();

        if (!isset($tokenResponse['access_token'])) {
            return redirect('/login')->withErrors([
                'vk' => 'Не удалось получить токен VK',
            ]);
        }

        $vkUserId = $tokenResponse['user_id'];
        $email = $tokenResponse['email'] ?? null;

        $userResponse = Http::get('https://api.vk.com/method/users.get', [
            'access_token' => $tokenResponse['access_token'],
            'user_ids' => $vkUserId,
            'fields' => 'photo_200',
            'v' => '5.131',
        ])->json();

        $vkUser = $userResponse['response'][0] ?? null;

        if (!$vkUser) {
            return redirect('/login')->withErrors([
                'vk' => 'Не удалось получить данные пользователя VK',
            ]);
        }

        $user = User::updateOrCreate(
            ['vk_id' => $vkUserId],
            [
                'first_name' => $vkUser['first_name'] ?? 'Пользователь',
                'last_name' => $vkUser['last_name'] ?? null,
                'email' => $email,
                'password' => bcrypt(Str::random(32)),
            ]
        );

        Auth::login($user, true);

        return redirect('/');
    }

    public function sdkLogin(Request $request)
{
    $data = $request->all();

    $vkId = $data['user_id'] ?? $data['id'] ?? null;

    if (!$vkId) {
        abort(422, 'VK user id not found');
    }

    $user = User::updateOrCreate(
        ['vk_id' => $vkId],
        [
            'first_name' => $data['first_name'] ?? 'Пользователь',
            'last_name' => $data['last_name'] ?? null,
            'email' => $data['email'] ?? null,
            'password' => bcrypt(\Illuminate\Support\Str::random(32)),
        ]
    );

    \Illuminate\Support\Facades\Auth::login($user, true);

    return response()->json(['ok' => true]);
}
}
