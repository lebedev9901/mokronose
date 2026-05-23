<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\CartController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VkAuthController extends Controller
{
    public function callback(Request $request)
    {
        if ($request->input('state') === 'mobile') {
            return $this->mobileCallback($request);
        }
        return redirect('/login')->withErrors([
            'vk' => 'VK callback используется только для SDK. Повторите вход через кнопку VK ID.',
        ]);
    }

    private function decodeIdToken(?string $idToken): array
    {
        if (!$idToken) {
            return [];
        }

        $parts = explode('.', $idToken);

        if (count($parts) !== 3) {
            return [];
        }

        $payload = $parts[1];
        $payload .= str_repeat('=', (4 - strlen($payload) % 4) % 4);

        return json_decode(base64_decode(strtr($payload, '-_', '+/')), true) ?: [];
    }

    private function getUserData(Request $request): array
    {
        $payload = $this->decodeIdToken($request->input('id_token'));
        $profileUser = $request->input('profile.user', []);

        return [
            'vk_id' => (string) (
                $request->input('user_id')
                ?? data_get($profileUser, 'user_id')
                ?? $payload['sub']
                ?? ''
            ),

            'first_name' => data_get($profileUser, 'first_name')
                ?? $payload['given_name']
                ?? $payload['first_name']
                ?? 'Пользователь',

            'last_name' => data_get($profileUser, 'last_name')
                ?? $payload['family_name']
                ?? $payload['last_name']
                ?? '',

            'middle_name' => data_get($profileUser, 'middle_name')
                ?? $payload['middle_name']
                ?? null,

            'email' => data_get($profileUser, 'email')
                ?? $request->input('email')
                ?? $payload['email']
                ?? null,

            'phone' => data_get($profileUser, 'phone')
                ?? $request->input('phone')
                ?? $payload['phone_number']
                ?? null,

            'avatar' => data_get($profileUser, 'avatar')
                ?? $payload['picture']
                ?? $payload['photo_200']
                ?? null,
        ];
    }

    public function sdkLogin(Request $request)
    {
        $data = $this->getUserData($request);

        if (!$data['vk_id']) {
            return response()->json([
                'ok' => false,
                'message' => 'VK ID не получен',
            ], 422);
        }

        $user = User::where('vk_id', $data['vk_id'])->first();

        if (!$user && $data['email']) {
            $user = User::where('email', $data['email'])->first();
        }

        if (!$user && $data['phone']) {
            $user = User::where('phone', $data['phone'])->first();
        }

        if (!$user) {
            $user = User::create([
                'vk_id' => $data['vk_id'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'middle_name' => $data['middle_name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'avatar' => $data['avatar'],
                'password' => bcrypt(str()->random(32)),
            ]);
        } else {
            $user->update([
                'vk_id' => $user->vk_id ?: $data['vk_id'],
                'first_name' => $user->first_name ?: $data['first_name'],
                'last_name' => $user->last_name ?: $data['last_name'],
                'middle_name' => $user->middle_name ?: $data['middle_name'],
                'email' => $user->email ?: $data['email'],
                'phone' => $user->phone ?: $data['phone'],
                'avatar' => $data['avatar'],
            ]);
        }

        Auth::login($user, true);

        CartController::mergeGuestCart();

        return response()->json([
            'ok' => true,
            'redirect' => route('dashboard'),
        ]);
    }

    public function mobileLogin(Request $request)
    {
        $data = $this->getUserData($request);

        if (!$data['vk_id']) {
            return response()->json([
                'ok' => false,
                'message' => 'VK ID не получен',
            ], 422);
        }

        $user = User::where('vk_id', $data['vk_id'])->first();

        if (!$user && $data['email']) {
            $user = User::where('email', $data['email'])->first();
        }

        if (!$user && $data['phone']) {
            $user = User::where('phone', $data['phone'])->first();
        }

        if (!$user) {
            $user = User::create([
                'vk_id' => $data['vk_id'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'middle_name' => $data['middle_name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'avatar' => $data['avatar'],
                'password' => bcrypt(str()->random(32)),
            ]);
        } else {
            $user->update([
                'vk_id' => $user->vk_id ?: $data['vk_id'],
                'first_name' => $user->first_name ?: $data['first_name'],
                'last_name' => $user->last_name ?: $data['last_name'],
                'middle_name' => $user->middle_name ?: $data['middle_name'],
                'email' => $user->email ?: $data['email'],
                'phone' => $user->phone ?: $data['phone'],
                'avatar' => $data['avatar'],
            ]);
        }

        $token = $user->createToken($request->input('device_name', 'mobile-app'))->plainTextToken;

        return response()->json([
            'ok' => true,
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function link(Request $request)
    {
        $data = $this->getUserData($request);

        if (!$data['vk_id']) {
            return response()->json([
                'ok' => false,
                'message' => 'VK ID не получен',
            ], 422);
        }

        $exists = User::where('vk_id', $data['vk_id'])
            ->where('id', '!=', Auth::id())
            ->exists();

        if ($exists) {
            return response()->json([
                'ok' => false,
                'message' => 'Этот VK уже привязан к другому пользователю',
            ], 409);
        }

        $user = Auth::user();

        $user->update([
            'vk_id' => $data['vk_id'],
            'first_name' => $user->first_name ?: $data['first_name'],
            'last_name' => $user->last_name ?: $data['last_name'],
            'middle_name' => $user->middle_name ?: $data['middle_name'],
            'email' => $user->email ?: $data['email'],
            'phone' => $user->phone ?: $data['phone'],
            'avatar' => $data['avatar'],
        ]);

        return response()->json([
            'ok' => true,
            'message' => 'VK привязан',
        ]);
    }

    public function mobileCallback(Request $request)
    {
        $code = $request->input('code');

        if (!$code) {
            return response('VK code отсутствует');
        }

        $tokenResponse = \Illuminate\Support\Facades\Http::get('https://oauth.vk.com/access_token', [
            'client_id' => config('services.vk.client_id'),
            'client_secret' => config('services.vk.client_secret'),
            'redirect_uri' => 'https://mokronos.ru/vk/mobile-callback',
            'code' => $code,
        ]);

        $tokenData = $tokenResponse->json();

        if (!isset($tokenData['access_token'])) {
            return response('Ошибка получения VK access_token: ' . json_encode($tokenData, JSON_UNESCAPED_UNICODE));
        }

        $userResponse = \Illuminate\Support\Facades\Http::get('https://api.vk.com/method/users.get', [
            'access_token' => $tokenData['access_token'],
            'fields' => 'photo_200',
            'v' => '5.199',
        ]);

        $vkData = $userResponse->json();

        if (!isset($vkData['response'][0])) {
            return response('Ошибка получения пользователя VK: ' . json_encode($vkData, JSON_UNESCAPED_UNICODE));
        }

        $vkUser = $vkData['response'][0];

        $user = User::where('vk_id', (string) $vkUser['id'])->first();

        if (!$user && isset($tokenData['email'])) {
            $user = User::where('email', $tokenData['email'])->first();
        }

        if (!$user) {
            $user = User::create([
                'vk_id' => (string) $vkUser['id'],
                'first_name' => $vkUser['first_name'] ?? 'Пользователь',
                'last_name' => $vkUser['last_name'] ?? '',
                'email' => $tokenData['email'] ?? null,
                'avatar' => $vkUser['photo_200'] ?? null,
                'password' => bcrypt(str()->random(32)),
            ]);
        } else {
            $user->update([
                'vk_id' => $user->vk_id ?: (string) $vkUser['id'],
                'first_name' => $user->first_name ?: ($vkUser['first_name'] ?? 'Пользователь'),
                'last_name' => $user->last_name ?: ($vkUser['last_name'] ?? ''),
                'email' => $user->email ?: ($tokenData['email'] ?? null),
                'avatar' => $vkUser['photo_200'] ?? $user->avatar,
            ]);
        }

        $appToken = $user->createToken('mobile-app')->plainTextToken;

        return redirect()->away('mokronose://vk-auth?token=' . urlencode($appToken));
    }
}