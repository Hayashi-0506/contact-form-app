<?php

namespace Tests\Feature;

use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UnauthenticatedRedirectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 未認証ユーザーはタスク一覧にアクセスするとログインページにリダイレクトされる(): void
    {
        $response = $this->get(route('admin.index'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function 未認証ユーザーはタグ編集画面にアクセスするとログインページにリダイレクトされる(): void
    {
        $tag = Tag::factory()->create();

        $response = $this->get(route('admin.tags.edit',$tag));

        $response->assertRedirect(route('login'));
    }
}
