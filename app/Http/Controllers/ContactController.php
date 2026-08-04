<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Tag;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * お問い合わせ一覧の取得
     */
    public function index()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('contact.index', compact('categories', 'tags'));
    }

    /**
     * 確認画面の取得
     */
    public function confirm(StoreContactRequest $request)
    {
        $validated = $request->validated();
        $category = Category::find($validated['category_id']);
        $tags = Tag::find($validated['tag_ids']);

        return view('contact.confirm', compact('validated', 'category', 'tags'));
    }

    /**
     * お問い合わせを新規作成
     */
    public function store(StoreContactRequest $request)
    {
        if ($request->input('action') === 'back') {
            return redirect()->route('contacts.index')->withInput();
        }

        $validated = $request->validated();

        $contact = Contact::create($validated);
        $contact->tags()->attach($validated['tag_ids']);

        return redirect()->route('contacts.thanks')->with('success', 'お問い合わせを作成しました。');
    }

    /**
     * サンクスページの取得
     */
    public function thanks()
    {
        return view('contact.thanks');
    }
}
