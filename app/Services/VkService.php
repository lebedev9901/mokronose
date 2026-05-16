<?php 
namespace App\Services;

use iLluminate\Support\Facades\Http;


class VkService
{
    protected string $token;
    protected string $version = '5.131';

    public function __construct()
    {
        $this->token = config('services.vk.token');
    }

    public function sendMessage($userId, $message)
    {
        if (!$this->token) {
            return null; // просто ничего не делаем
        }
        return Http::post('https://api.vk.com/method/messages.send', [
            'user_id' => $userId,
            'message' => $message,
            'random_id' => rand(1, 999999999),
            'access_token' => $this->token,
            'v' => $this->version,
        ])->json();
    }
}