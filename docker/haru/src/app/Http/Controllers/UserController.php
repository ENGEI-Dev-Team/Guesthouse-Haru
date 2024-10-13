<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // ユーザートップページ
    public function index()
    {
        $latestBlogs = Blog::latest()->take(6)->get();
        return view('/user/top', compact('latestBlogs'));
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

        $blogs = $query->with('categories')->get();

        $categories = Category::all();

        return view('user.blog_lists', ['blogs' => $blogs, 'categories' => $categories]);
    }

    // ブログ詳細ページ
    public function blogDetail($id)
    {
        $blog = Blog::with('comments')->findOrFail($id);
        return view('user.blog_detail', compact('blog'));
    }

    // 内装ページ
    public function room()
    {
        return view('user.room');
    }
}
