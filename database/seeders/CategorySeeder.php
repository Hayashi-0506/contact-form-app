<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 商品のお届けについて
        Category::create([
            'content' => '商品のお届けについて',
        ]);

        // 商品の交換について
        Category::create([
            'content' => '商品の交換について',
        ]);

        // 商品トラブル
        Category::create([
            'content' => '商品トラブル',
        ]);

        // ショップへのお問い合わせ
        Category::create([
            'content' => 'ショップへのお問い合わせ',
        ]);

        // その他
        Category::create([
            'content' => 'その他',
        ]);
    }
}
