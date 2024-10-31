<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
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
            $imagePath = $request->file('image')->store('images/blogs', 'public');
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

        return redirect()->route('admin.blogLists')->with('create_success', 'ブログが作成されました。');
    }

    // ブログ一覧ページ
    public function blogLists(Request $request)
    {
        $query = Blog::query();

        // キーワード検索
        if ($request->has('keyword') && !empty($request->input('keyword'))) {
            $query->where('title', 'like', '%' . $request->input('keyword') . '%')
                ->orWhere('content', 'like', '%' . $request->input('keyword') . '%');
        }

        // カテゴリー検索
        if ($request->has('category') && !empty($request->input('category'))) {
            $query->whereHas('categories', function ($categoryQuery) use ($request) {
                $categoryQuery->where('category_id', $request->input('category'));
            });
        }

        // 並び順
        if ($request->has('order')) {
            if ($request->input('order') === 'newest') {
                $query->orderBy('created_at', 'desc');
            } else if ($request->input('order') === 'oldest') {
                $query->orderBy('created_at', 'asc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $blogs = $query->with('categories')->paginate(10);

        $categories = Category::all();

        return view('admin.blog_lists', ['blogs' => $blogs, 'categories' => $categories]);
    }

    // ブログ詳細ページ
    public function blogDetail($id)
    {
        $blog = Blog::with('comments')->findOrFail($id);
        return view('admin.blog_detail', compact('blog'));
    }

    // ブログ編集
    public function edit(Blog $blog)
    {
        $categories = Category::all();
        return view('admin.blog_edit', compact('blog', 'categories'));
    }

    public function update(Request $request, Blog $blog)
    {
        $validatedData = $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,webp',
            'title' => 'required|string|max:255',
            'content' => 'required|string|',
            'categories' => 'required|array'
        ], [
            'image.image' => '画像は画像ファイルである必要があります。',
            'image.mimes' => '画像はjpeg、png、jpg、またはwebp形式である必要があります。',
            'title.required' => 'タイトルを入力してください。',
            'title.max' => 'タイトルは255文字以内でなければなりません。',
            'content.required' => '内容を入力してください。',
            'categories.required' => '少なくとも1つのカテゴリを選択してください。',
        ]);

        if ($request->hasFile('image')) {
            if ($blog->image) {
                Storage::delete($blog->image);
            }

            $imagePath = $request->file('image')->store('images/blogs', 'public');
            $blog->update(['image' => $imagePath]);
        }

        $blog->update([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
        ]);

            $blog->categories()->sync($validatedData['categories']);

            return redirect()->route('admin.blogDetail', ['id' => $blog->id])->with('update_success', 'ブログを更新しました。');
    }

    // ブログ削除
    public function destroy(Blog $blog)
    {
        $blog->delete();

        return redirect()->route('admin.blogLists', $blog->id)->with('delete_success', 'ブログを削除しました。');
    }
}
