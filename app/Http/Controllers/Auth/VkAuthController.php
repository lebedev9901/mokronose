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

        return [
            'vk_id' => (string) $request->input('user_id'),
            'first_name' => $payload['given_name']
                ?? $payload['first_name']
                ?? 'Пользователь',
            'last_name' => $payload['family_name']
                ?? $payload['last_name']
                ?? '',
            'middle_name' => $payload['middle_name'] ?? null,
            'email' => $request->input('email') ?? ($payload['email'] ?? null),
            'phone' => $request->input('phone') ?? ($payload['phone_number'] ?? null),
            'avatar' => $payload['picture'] ?? $payload['photo_200'] ?? null,
        ];
    }

    public function sdkLogin(Request $request)
    {
        $data = $this->getUserData($request);

        if (!$data['vk_id']) {
            return response()->json([
                'ok' => false,
                'message' => 'VK ID не получен',
                'request' => $request->all(),
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
                'avatar' => $user->avatar ?: $data['avatar'],
            ]);
        }

        Auth::login($user, true);

        return response()->json([
            'ok' => true,
            'user' => $user,
            'vk_data' => $data,
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
            'avatar' => $user->avatar ?: $data['avatar'],
        ]);

        return response()->json([
            'ok' => true,
            'message' => 'VK привязан',
            'user' => $user,
            'vk_data' => $data,
        ]);
    }
}