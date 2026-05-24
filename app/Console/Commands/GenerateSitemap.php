<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

use App\Models\Product;
use App\Models\Category;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';

    protected $description = 'Generate sitemap.xml';

    public function handle(): void
    {
        $sitemap = Sitemap::create();

        // Главная
        $sitemap->add(
            Url::create('/')
                ->setPriority(1.0)
        );

        // Категории
        Category::all()->each(function ($category) use ($sitemap) {
            $sitemap->add(
                Url::create("/catalog/{$category->slug}")
                    ->setPriority(0.8)
            );
        });

        // Товары
        Product::all()->each(function ($product) use ($sitemap) {
            $sitemap->add(
                Url::create("/product/{$product->slug}")
                    ->setPriority(0.9)
            );
        });

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated!');
    }
}