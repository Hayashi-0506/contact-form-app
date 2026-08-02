<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 商品のお届けについて
        Tag::create([
            'name' => '質問',
        ]);

        // 商品の交換について
        Tag::create([
            'name' => '要望',
        ]);

        // 商品トラブル
        Tag::create([
            'name' => '不具合報告',
        ]);

        // ショップへのお問い合わせ
        Tag::create([
            'name' => 'ご意見',
        ]);

        // その他
        Tag::create([
            'name' => 'その他',
        ]);
    }
}
