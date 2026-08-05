<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // データベースに存在する前提のデータを作成
        Category::factory()->count(5)->create();
        Tag::factory()->count(5)->create();

    }

    /** @test */
    public function 認証済みユーザーは管理者画面にアクセスできる(): void
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this->actingAs($user)->get(route('admin.index'));

        // Assert
        $response->assertStatus(200);
        $response->assertViewHas('user');
        $response->assertViewHas('contacts');
        $response->assertViewHas('categories');
        $response->assertViewHas('tags');
    }

    /** @test */
    public function 認証済みユーザーはお問い合わせ詳細画面にアクセスできる(): void
    {
        // Arrange
        $user = User::factory()->create();
        $contact = Contact::factory()->create();

        // Act
        $response = $this->actingAs($user)->get(route('admin.show', $contact));

        // Assert
        $response->assertStatus(200);
    }

    /** @test */
    public function 認証済みユーザーはタグ編集画面にアクセスできる(): void
    {
        // Arrange
        $user = User::factory()->create();
        $tag = Tag::factory()->create();

        // Act
        $response = $this->actingAs($user)->get(route('admin.tags.edit', $tag));

        // Assert
        $response->assertStatus(200);
    }
}
