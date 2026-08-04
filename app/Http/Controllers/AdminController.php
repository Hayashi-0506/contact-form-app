<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Tag;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * お問い合わせ一覧を表示
     */
    public function index(Request $request)
    {
        $keyword = $request->query('keyword');
        $gender = $request->query('gender');
        $category_id = $request->query('category_id');
        $date = $request->query('date');

        // 検索条件を基にContactsを取得。
        $contacts = Contact::query()
            ->when($keyword, function ($query, $keyword) {
                return $query->where('first_name', 'like', "%{$keyword}%")
                    ->orWhere('last_name', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%");
            })
            ->when($gender, function ($query, $gender) {
                return $query->where('gender', $gender);
            })
            ->when($category_id, function ($query, $category_id) {
                return $query->where('category_id', $category_id);
            })
            ->when($date, function ($query, $date) {
                return $query->whereDate('updated_at', $date);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(7);

        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.index', [
            'user' => $request->user(),
            'categories' => $categories,
            'contacts' => $contacts,
            'tags' => $tags,
        ]);
    }

    /**
     * お問い合わせの詳細を表示
     */
    public function show(string $id)
    {
        $contact = Contact::find($id);

        return view('admin.show', ['contact' => $contact]);
    }

    /**
     * お問い合わせを削除
     */
    public function destroy(string $id)
    {
        $contact = Contact::find($id);

        $contact->delete();

        return redirect()->route('admin.index')
            ->with('success', 'お問い合わせを削除しました。');
    }
}
