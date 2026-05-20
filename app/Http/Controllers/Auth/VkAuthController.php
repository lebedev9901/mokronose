<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class VkAuthController extends Controller
{
    public function redirect()
    {
        $query = http_build_query([
            'client_id' => config('services.vkontakte.client_id'),
            'redirect_uri' => config('services.vkontakte.redirect'),
            'scope' => 'email phone',
            'response_type' => 'code',
            'v' => '5.131',
        ]);

        return redirect('https://oauth.vk.com/authorize?' . $query);
    }

    public function callback()
    {


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
                'middle_name' => null,
                'email' => $vkEmail,
                'password' => bcrypt(Str::random(32)),
                'vk_id' => $vkId,
                 'phone' => $vkPhone,
            ]
        );

        Auth::login($user, true);

        return redirect('/');
    }

    public function sdkLogin(Request $request)
{
    $vkId = (string) $request->input('user_id');
    $accessToken = $request->input('access_token');

    if (!$vkId) {
        return response()->json([
            'ok' => false,
            'message' => 'VK ID не получен',
        ], 422);
    }

    $vkUser = null;

    if ($accessToken) {
        $response = Http::get('https://api.vk.com/method/users.get', [
            'access_token' => $accessToken,
            'user_ids' => $vkId,
            'fields' => 'photo_200',
            'v' => '5.131',
        ])->json();

        $vkUser = $response['response'][0] ?? null;
    }

    // 1. Если пользователь уже вошёл — привязываем VK ID
    if (Auth::check()) {
        $user = Auth::user();

        $vkAlreadyLinked = User::where('vk_id', $vkId)
            ->where('id', '!=', $user->id)
            ->exists();

        if ($vkAlreadyLinked) {
            return response()->json([
                'ok' => false,
                'message' => 'Этот VK ID уже привязан к другому аккаунту',
            ], 409);
        }

        $user->update([
            'vk_id' => $vkId,
            'phone' => $user->phone ?: $request->input('phone'),
        ]);

        return response()->json([
            'ok' => true,
            'message' => 'VK ID привязан',
        ]);
    }

    // 2. Если пользователь не вошёл — ищем аккаунт с таким VK ID
    $user = User::where('vk_id', $vkId)->first();

    if ($user) {
        Auth::login($user, true);

        return response()->json([
            'ok' => true,
            'message' => 'Вход выполнен',
        ]);
    }

    // 3. Если VK ID не привязан — не создаём дубль
    return response()->json([
        'ok' => false,
        'message' => 'VK ID не привязан. Сначала войдите обычным способом и привяжите VK в профиле.',
    ], 404);
}
}
