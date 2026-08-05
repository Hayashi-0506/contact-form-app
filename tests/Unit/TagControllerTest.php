<?php

namespace Tests\Unit;

use App\Http\Requests\UpdateTagRequest;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Tests\TestCase;

class TagControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function タグ名称正常テスト()
    {
        $request = new UpdateTagRequest;

        $request->merge(['name' => 'テスト']);

        $validator = FacadesValidator::make($request->all(), $request->rules());
        $this->assertTrue($validator->passes());
    }

    /** @test */
    public function タグ名称未入力テスト()
    {
        $request = new UpdateTagRequest;

        $request->merge(['name' => '']);

        $validator = FacadesValidator::make($request->all(), $request->rules());
        $this->assertFalse($validator->passes());
    }

    /** @test */
    public function タグ名称文字数正常テスト()
    {
        $request = new UpdateTagRequest;

        $request->merge(['name' => str_repeat('あ', 50)]);

        $validator = FacadesValidator::make($request->all(), $request->rules());
        $this->assertTrue($validator->passes());
    }

    /** @test */
    public function タグ名称文字数超過テスト()
    {
        $request = new UpdateTagRequest;

        $request->merge(['name' => str_repeat('あ', 51)]);

        $validator = FacadesValidator::make($request->all(), $request->rules());
        $this->assertFalse($validator->passes());
    }

    /** @test */
    public function タグ名称重複テスト()
    {
        $tag = Tag::factory()->create();

        $request = new UpdateTagRequest;

        $request->merge(['name' => $tag->name]);

        $validator = FacadesValidator::make($request->all(), $request->rules());
        $this->assertFalse($validator->passes());
    }

    /** @test */
    public function タグ名称同一名称更新テスト()
    {
        $tag = Tag::factory()->create();
        $request = new UpdateTagRequest;
        
        $rules = $request->rules();
        $rules['name'] = $rules['name'] . $tag->id;

        $validator = FacadesValidator::make($tag->toArray(), $request->rules());
        $this->assertFalse($validator->passes());
    }
}
