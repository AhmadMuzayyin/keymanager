<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Android',
                'slug' => 'android',
                'icon' => '📱',
            ],
            [
                'name' => 'Desktop',
                'slug' => 'desktop',
                'icon' => '🖥️',
            ],
            [
                'name' => 'Web Application',
                'slug' => 'web-application',
                'icon' => '🌐',
            ],
            [
                'name' => 'Source Code',
                'slug' => 'source-code',
                'icon' => '💻',
            ],
            [
                'name' => 'Template',
                'slug' => 'template',
                'icon' => '📄',
            ],
            [
                'name' => 'Plugin',
                'slug' => 'plugin',
                'icon' => '🔌',
            ],
            [
                'name' => 'API Service',
                'slug' => 'api-service',
                'icon' => '⚡',
            ],
            [
                'name' => 'Game',
                'slug' => 'game',
                'icon' => '🎮',
            ],
            [
                'name' => 'E-Commerce',
                'slug' => 'e-commerce',
                'icon' => '🛒',
            ],
            [
                'name' => 'Management System',
                'slug' => 'management-system',
                'icon' => '📊',
            ],
        ];

        foreach ($categories as $category) {
            ProductCategory::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
