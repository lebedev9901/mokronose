<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class VkAuthController extends Controller
{
    public function callback()
    {
        return redirect('/login')->withErrors([
            'vk' => 'VK callback используется только для SDK. Повторите вход через кнопку VK ID.',
        ]);
    }

    public function sdkLogin(Request $request)
    {
        $vkId = (string) $request->input('user_id');
        $accessToken = $request->input('access_token');
        $email = $request->input('email');
        $phone = $request->input('phone');

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

        /**
         * 1. Пользователь уже авторизован — привязываем VK ID
         */
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
                'first_name' => $user->first_name ?: ($vkUser['first_name'] ?? $user->first_name),
                'last_name' => $user->last_name ?: ($vkUser['last_name'] ?? $user->last_name),
                'email' => $user->email ?: $email,
                'phone' => $user->phone ?: $phone,
            ]);

            return response()->json([
                'ok' => true,
                'message' => 'VK ID успешно привязан',
            ]);
        }

        /**
         * 2. Пользователь не авторизован — ищем существующий аккаунт по VK ID
         */
        $user = User::where('vk_id', $vkId)->first();

        if ($user) {
            $user->update([
                'first_name' => $user->first_name ?: ($vkUser['first_name'] ?? $user->first_name),
                'last_name' => $user->last_name ?: ($vkUser['last_name'] ?? $user->last_name),
                'email' => $user->email ?: $email,
                'phone' => $user->phone ?: $phone,
            ]);

            Auth::login($user, true);

            return response()->json([
                'ok' => true,
                'message' => 'Вход выполнен',
            ]);
        }

        /**
         * 3. VK ID не привязан — НЕ создаём нового пользователя
         */
        return response()->json([
            'ok' => false,
            'message' => 'VK ID не привязан. Сначала войдите обычным способом и привяжите VK ID в профиле.',
        ], 404);
    }
}
