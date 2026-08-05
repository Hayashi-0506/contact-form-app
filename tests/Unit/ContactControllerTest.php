<?php

namespace Tests\Unit;

use App\Http\Requests\StoreContactRequest;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class ContactControllerTest extends TestCase
{
    use RefreshDatabase;

    private static array $validBaseData = [];

    /**
     * 各テストメソッドが実行される前の初期化処理
     * データベース依存の正常系データをここで組み立てる
     */
    protected function setUp(): void
    {
        parent::setUp();

        // データベースに存在する前提のデータを作成
        $category = Category::factory()->create();
        $tag = Tag::factory()->create();

        // すべてのバリデーションを通過する「基本の正常系データ」を定義
        self::$validBaseData = [
            'category_id' => $category->id,
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
            'tag_ids' => [$tag->id],
        ];
    }

    /** @test */
    public function 正常テスト()
    {
        $request = new StoreContactRequest;

        $request->merge(self::$validBaseData);

        $validator = Validator::make($request->all(), $request->rules());
        $this->assertTrue($validator->passes());
    }

    /** @test */
    public function 姓未入力テスト()
    {
        $request = new StoreContactRequest;

        $request->merge(self::$validBaseData);
        $request->merge(['first_name' => '']);

        $validator1 = Validator::make($request->all(), $request->rules());
        $this->assertFalse($validator1->passes());
    }

    /** @test */
    public function 名未入力テスト()
    {
        $request = new StoreContactRequest;

        $request->merge(self::$validBaseData);
        $request->merge(['last_name' => '']);

        $validator1 = Validator::make($request->all(), $request->rules());
        $this->assertFalse($validator1->passes());
    }

    public function 性別範囲外テスト()
    {
        $request = new StoreContactRequest;

        $request->merge(self::$validBaseData);
        $request->merge(['gender' => 999]);

        $validator1 = Validator::make($request->all(), $request->rules());
        $this->assertFalse($validator1->passes());
    }

    public function メール未入力テスト()
    {
        $request = new StoreContactRequest;

        $request->merge(self::$validBaseData);
        $request->merge(['email' => '']);

        $validator1 = Validator::make($request->all(), $request->rules());
        $this->assertFalse($validator1->passes());
    }

    /** @test */
    public function メール不正テスト()
    {
        $request = new StoreContactRequest;

        $request->merge(self::$validBaseData);
        $request->merge(['email' => 'tesst']);

        $validator1 = Validator::make($request->all(), $request->rules());
        $this->assertFalse($validator1->passes());
    }

    /** @test */
    public function 電話番号未入力テスト()
    {
        $request = new StoreContactRequest;

        $request->merge(self::$validBaseData);
        $request->merge(['tel' => '']);

        $validator1 = Validator::make($request->all(), $request->rules());
        $this->assertFalse($validator1->passes());
    }

    /** @test */
    public function 電話番号不正テスト()
    {
        $request = new StoreContactRequest;

        $request->merge(self::$validBaseData);
        $request->merge(['tel' => '080-1234-5678']);

        $validator1 = Validator::make($request->all(), $request->rules());
        $this->assertFalse($validator1->passes());
    }

    /** @test */
    public function 住所未入力テスト()
    {
        $request = new StoreContactRequest;

        $request->merge(self::$validBaseData);
        $request->merge(['address' => '']);

        $validator1 = Validator::make($request->all(), $request->rules());
        $this->assertFalse($validator1->passes());
    }

    /** @test */
    public function 詳細未入力テスト()
    {
        $request = new StoreContactRequest;

        $request->merge(self::$validBaseData);
        $request->merge(['detail' => '']);

        $validator1 = Validator::make($request->all(), $request->rules());
        $this->assertFalse($validator1->passes());
    }

    /** @test */
    public function タグ不正テスト()
    {
        $request = new StoreContactRequest;

        $request->merge(self::$validBaseData);
        $request->merge(['tag_ids' => [1, 3, 999]]);

        $validator1 = Validator::make($request->all(), $request->rules());
        $this->assertFalse($validator1->passes());
    }

    /** @test */
    public function お問い合わせ内容とタグを紐づけて作成できる(): void
    {
        $contact = Contact::create(self::$validBaseData);
        $contact->tags()->attach(self::$validBaseData['tag_ids']);
        
        $contacts = Contact::find($contact->id)->with('tags')->get();
        
        foreach ($contacts as $contact) {
            $this->assertTrue($contact->tags->isNotEmpty());
        }
    }
}
