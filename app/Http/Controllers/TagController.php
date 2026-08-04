<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateTagRequest;
use App\Models\Tag;

class TagController extends Controller
{
    /**
     * タグの新規作成
     */
    public function store(UpdateTagRequest $request)
    {
        $validate = $request->validated();

        Tag::create($validate);

        return redirect()->route('admin.index')
            ->with('success', 'タグを作成しました。');
    }

    /**
     * タグ編集画面を表示
     */
    public function edit(string $id)
    {
        $tag = Tag::find($id);

        return view('admin.tags.edit', ['tag' => $tag]);
    }

    /**
     * タグ名を更新
     */
    public function update(UpdateTagRequest $request, string $id)
    {
        $validate = $request->validated();
        $tag = Tag::findOrFail($id);
        $tag->name = $validate['name'];
        $tag->save();

        return redirect()->route('admin.index')
            ->with('success', 'タグを更新しました。');
    }

    /**
     * タグ名を削除
     */
    public function destroy(string $id)
    {
        $tag = Tag::find($id);

        $tag->delete();

        return redirect()->route('admin.index')
            ->with('success', 'タグを削除しました。');
    }
}
