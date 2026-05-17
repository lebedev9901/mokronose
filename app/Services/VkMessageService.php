<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class VkMessageService
{
    /**
     * Create a new class instance.
     */
    public function send(string $message): void
    {
        $token = config('services.vk.group_token');
        $peerId = config('services.vk.admin_peer_id');

        if (!$token || !$peerId) {
            return;
        }

        Http::asForm()->post('https://api.vk.com/method/messages.send', [
            'access_token' => $token,
            'v' => '5.199',
            'peer_id' => $peerId,
            'message' => $message,
            'random_id' => random_int(1, PHP_INT_MAX),
        ]);
    }
}
