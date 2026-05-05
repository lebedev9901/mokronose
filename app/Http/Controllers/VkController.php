<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VkController extends Controller
{
    public function redirect()
    {
        $url = "https://oauth.vk.com/authorize?" . http_build_query([
            'client_id' => config('services.vk.client_id'),
            'redirect_uri' => config('services.vk.redirect'),
            'response_type' => 'code',
            'scope' => 'offline',
            'v' => '5.131'
        ]);

        return redirect($url);
    }

    public function callback(Request $request)
    {
        $response = Http::get('https://oauth.vk.com/access_token', [
            'client_id' => config('services.vk.client_id'),
            'client_secret' => config('services.vk.client_secret'),
            'redirect_uri' => config('services.vk.redirect'),
            'code' => $request->code,
        ])->json();

        if (!isset($response['user_id'])) {
            return redirect()->route('profile')->with('error', 'VK ошибка');
        }

        auth()->user()->update([
            'vk_id' => $response['user_id']
        ]);

        return redirect()->route('profile')->with('success', 'VK привязан');
    }
}
