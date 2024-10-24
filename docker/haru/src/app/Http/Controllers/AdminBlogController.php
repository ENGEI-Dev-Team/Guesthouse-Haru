<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminBlogController extends Controller
{
    // ブログ作成
    public function create()
    {
        $categories = Category::all();
        return view('admin.create_blog', compact('categories'));
    }


    // ブログ保存
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp',
            'title' => 'required|string|max:255',
            'content' => 'required|string|',
            'categories' => 'required|array'
        ], [
            'image.required' => '画像を挿入してください',
            'image.image' => '画像は画像ファイルである必要があります。',
            'image.mimes' => '画像はjpeg、png、jpg、またはwebp形式である必要があります。',
            'title.required' => 'タイトルを入力してください。',
            'title.max' => 'タイトルは255文字以内でなければなりません。',
            'content.required' => '内容を入力してください。',
            'categories.required' => '少なくとも1つのカテゴリを選択してください。',
        ]);

        // 画像のアップロード
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        } else {
            return back()->withErrors(['image' => '画像がアップロードされていません。'])->withInput();
        }

        $adminId = Auth::guard('admin')->id();

        $blog = Blog::create([
            'id' => (string) Str::uuid(),
            'admin_id' => $adminId,
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'image' => $imagePath,
        ]);

        // カテゴリを関連付け
        $blog->categories()->sync($validatedData['categories']);

        return redirect()->route('admin.blogLists')->with('success', 'ブログが作成されました。');
    }

    // ブログ一覧ページ
    public function blogLists()
    {
        $blogs = Blog::with('categories')->get();
        return view('admin.blog_lists', compact('blogs'));
    }
}
