<?php

namespace App\Http\Controllers;

use App\DDD\Blog\UseCase\GetBlogsUseCase;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;

class UserController extends Controller
{   
    private $getBlogsUseCase;

    public function __construct(GetBlogsUseCase $getBlogsUseCase)
    {
        $this->getBlogsUseCase = $getBlogsUseCase;
    }

    // ユーザートップページ
    public function index()
    {
        $latestBlogs = Blog::latest()->take(6)->get();
        return view('/user/top', compact('latestBlogs'));
    }

    // ブログ一覧ページ
    public function blogLists(Request $request)
    {
        $filters = $request->only(['keyword', 'category', 'order']);
        $blogs = $this->getBlogsUseCase->execute($filters);

        $categories = Category::all();

        return view('admin.blog_lists', ['blogs' => $blogs, 'categories' => $categories]);
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
