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
            'fields' => 'photo_200,contacts',
            'v' => '5.131',
        ])->json();

        $vkUser = $response['response'][0] ?? null;
    }

    $email = $request->input('email');
    $phone = $request->input('phone') ?? ($vkUser['mobile_phone'] ?? null);

    $user = User::where('vk_id', $vkId)->first();

    if (!$user) {
        $user = User::create([
            'vk_id' => $vkId,
            'first_name' => $vkUser['first_name'] ?? 'Пользователь',
            'last_name' => $vkUser['last_name'] ?? '',
            'middle_name' => null,
            'email' => $email,
            'phone' => $phone,
            'avatar' => $vkUser['photo_200'] ?? null,
            'password' => bcrypt(str()->random(32)),
        ]);
    } else {
        $user->update([
            'first_name' => $vkUser['first_name'] ?? $user->first_name,
            'last_name' => $vkUser['last_name'] ?? $user->last_name,
            'email' => $user->email ?: $email,
            'phone' => $user->phone ?: $phone,
            'avatar' => $vkUser['photo_200'] ?? $user->avatar,
        ]);
    }

    Auth::login($user, true);

    return response()->json([
        'ok' => true,
        'user' => $user,
    ]);
}
}
