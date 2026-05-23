<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\VkReview;
use Illuminate\Console\Command;
use VK\Client\VKApiClient;

class SyncVkReviews extends Command
{
    protected $signature = 'vk:sync-reviews';

    protected $description = 'Sync reviews from VK group';


    private function isReviewText(string $text): bool
    {
        $text = mb_strtolower(trim($text));

        if (mb_strlen($text) < 20) {
            return false;
        }

        $badWords = [
            'цена',
            'сколько',
            'есть в наличии',
            'как заказать',
            'доставка',
            '?',
        ];

        foreach ($badWords as $word) {
            if (str_contains($text, $word)) {
                return false;
            }
        }

        $reviewWords = [
            'купили',
            'брали',
            'понравилось',
            'понравился',
            'понравилась',
            'спасибо',
            'отлично',
            'хороший',
            'хорошая',
            'рекомендую',
            'собака',
            'щенок',
            'ест',
            'кушает',
        ];

        foreach ($reviewWords as $word) {
            if (str_contains($text, $word)) {
                return true;
            }
        }

        return false;
    }

    public function handle(): int
    {
        $token = config('services.vkontakte.token');
        $groupId = config('services.vkontakte.group_id');

        if (!$token || !$groupId) {
            $this->error('VK token or group_id is missing');
            return self::FAILURE;
        }

        $vk = new VKApiClient();
        $ownerId = '-' . $groupId;

        $posts = $vk->wall()->get($token, [
            'owner_id' => $ownerId,
            'count' => 100,
            'filter' => 'owner',
        ]);

        $products = Product::all();

        foreach ($posts['items'] as $post) {
            sleep(1);

            $postText = mb_strtolower($post['text'] ?? '');

            $matchedProduct = null;

            foreach ($products as $product) {
                $productName = mb_strtolower($product->name);

                if (str_contains($postText, $productName)) {
                    $matchedProduct = $product;
                    break;
                }
            }

            if (!$matchedProduct) {
                continue;
            }

            $comments = $vk->wall()->getComments($token, [
                'owner_id' => $ownerId,
                'post_id' => $post['id'],
                'count' => 100,
                'extended' => 1,
            ]);

            foreach ($comments['items'] as $comment) {
                $text = trim($comment['text'] ?? '');

                if (!$this->isReviewText($text)) {
                    continue;
                }

                VkReview::updateOrCreate(
                    [
                        'vk_comment_id' => $post['id'] . '_' . $comment['id'],
                    ],
                    [
                        'product_id' => null,
                        'author_name' => 'Покупатель VK',
                        'text' => $text,
                        'vk_created_at' => isset($comment['date'])
                            ? date('Y-m-d H:i:s', $comment['date'])
                            : null,
                    ]
                );
                
            }
        }

        $this->info('VK reviews synced');

        return self::SUCCESS;
    }
}
