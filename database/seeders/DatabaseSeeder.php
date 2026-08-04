<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Contact;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            TagSeeder::class,
        ]);

        // contacts テーブルに20件のダミーデータを投入
        Contact::factory()
            ->count(20)
            ->create()
            ->each(function ($contact) {
                $contact->tags()->attach(Tag::inRandomOrder()->take(3)->pluck('id'));
            });
    }
}
