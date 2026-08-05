<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactControllerTest extends TestCase
{
    use RefreshDatabase;

    private static array $validBaseData = [];

    protected function setUp(): void
    {
        parent::setUp();

        // データベースに存在する前提のデータを作成
        Category::factory()->count(5)->create();
        Tag::factory()->count(5)->create();

        // すべてのバリデーションを通過する「基本の正常系データ」を定義
        self::$validBaseData = [
            'category_id' => 1,
            'first_name' => '山田',
            'last_name' => '太郎',
            'gender' => 1,
            'email' => 'test@example.com',
            'tel' => '09012345678',
            'tel1' => '090',
            'tel2' => '1234',
            'tel3' => '5678',
            'address' => '東京都杉並区',
            'building' => 'コーポサザン101',
            'detail' => '問い合わせ内容のテキストです。',
            'tag_ids' => [1, 2, 3],
        ];
    }

    /** @test */
    public function お問い合わせフォーム入力ページが表示できる(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function お問い合わせ内容を確認できる(): void
    {
        $response = $this->post(route('contacts.confirm'), self::$validBaseData);

        $response->assertStatus(200);
        $response->assertViewIs('contact.confirm');
    }

    /** @test */
    public function 姓未入力時のバリデーションチェック(): void
    {
        self::$validBaseData['first_name'] = '';
        $response = $this->post(route('contacts.confirm'), self::$validBaseData);

        $response->assertSessionHasErrors(['first_name']);
    }

    /** @test */
    public function 名未入力時のバリデーションチェック(): void
    {
        self::$validBaseData['last_name'] = '';
        $response = $this->post(route('contacts.confirm'), self::$validBaseData);

        $response->assertSessionHasErrors(['last_name']);
    }

    /** @test */
    public function 性別未入力時のバリデーションチェック(): void
    {
        self::$validBaseData['gender'] = '';
        $response = $this->post(route('contacts.confirm'), self::$validBaseData);

        $response->assertSessionHasErrors(['gender']);
    }

    /** @test */
    public function 電話番号未入力時のバリデーションチェック(): void
    {
        self::$validBaseData['tel'] = '';
        $response = $this->post(route('contacts.confirm'), self::$validBaseData);

        $response->assertSessionHasErrors(['tel']);
    }

    /** @test */
    public function 電話番号の形式違いのバリデーションチェック(): void
    {
        self::$validBaseData['tel'] = '080-1111-2222';
        $response = $this->post(route('contacts.confirm'), self::$validBaseData);

        $response->assertSessionHasErrors(['tel']);
    }

    /** @test */
    public function 住所未入力時のバリデーションチェック(): void
    {
        self::$validBaseData['address'] = '';
        $response = $this->post(route('contacts.confirm'), self::$validBaseData);

        $response->assertSessionHasErrors(['address']);
    }

    /** @test */
    public function お問い合わせの種類未入力時のバリデーションチェック(): void
    {
        self::$validBaseData['category_id'] = null;
        $response = $this->post(route('contacts.confirm'), self::$validBaseData);

        $response->assertSessionHasErrors(['category_id']);
    }

    /** @test */
    public function お問い合わせの詳細未入力時のバリデーションチェック(): void
    {
        self::$validBaseData['detail'] = null;
        $response = $this->post(route('contacts.confirm'), self::$validBaseData);

        $response->assertSessionHasErrors(['detail']);
    }

    /** @test */
    public function お問い合わせ内容を登録できる(): void
    {
        $response = $this->post(route('contacts.store'), self::$validBaseData);

        // サンクスページにリダイレクトされることを確認
        $response->assertRedirect(route('contacts.thanks'));
    }
}
