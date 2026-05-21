<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VkMessageService
{
    public function sendToUser(string|int $vkUserId, string $message): bool
    {
        if (!$vkUserId) {
            return false;
        }

        $response = Http::asForm()->post('https://api.vk.com/method/messages.send', [
            'access_token' => config('services.vkontakte.community_token'),
            'v' => config('services.vkontake.api_version', '5.131'),
            'user_id' => $vkUserId,
            'random_id' => random_int(1, PHP_INT_MAX),
            'message' => $message,
        ]);

        $data = $response->json();

        if (isset($data['error'])) {
            Log::warning('VK message send error', $data);
            return false;
        }

        return true;
    }
}