<?php

namespace App\Http\Controllers;

use App\DDD\Blog\UseCase\CreateBlogUseCase;
use App\DDD\Blog\UseCase\GetBlogsUseCase;
use App\DDD\Blog\UseCase\UpdateBlogUseCase;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminBlogController extends Controller
{
    private $createBlogUseCase;
    private $getBlogsUseCase;
    private $updateBlogUseCase;

    public function __construct(CreateBlogUseCase $createBlogUseCase, GetBlogsUseCase $getBlogsUseCase, UpdateBlogUseCase $updateBlogUseCase)
    {
        $this->createBlogUseCase = $createBlogUseCase;
        $this->getBlogsUseCase = $getBlogsUseCase;
        $this->updateBlogUseCase = $updateBlogUseCase;
    }

    // ブログ作成
    public function create()
    {
        $categories = Category::all();
        return view('admin.create_blog', compact('categories'));
    }

    // ブログ保存
    public function store(StoreBlogRequest $request)
    {
        // 画像のアップロード
        if (!$request->hasFile('image')) {
            return back()->withErrors(['image' => '画像がアップロードされていません。'])->withInput();
        }
        $imagePath = $request->file('image')->store('images/blogs', 'public');

        $adminId = Auth::guard('admin')->id();

        $this->createBlogUseCase->execute(
            $adminId, 
            $request['title'], 
            $request['content'], 
            $imagePath,  
            $request['categories']
        );

        return redirect()->route('admin.blogLists')->with('create_success', 'ブログが作成されました。');
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
        return view('admin.blog_detail', compact('blog'));
    }

    // ブログ編集
    public function edit(Blog $blog)
    {
        $categories = Category::all();
        return view('admin.blog_edit', compact('blog', 'categories'));
    }

    public function updateImage(Request $request, Blog $blog): ?string
    {
        if (!$request->hasFile('image')) {
            return null;
        }

        $existingImagePath = $blog->getImagePath();
        if ($existingImagePath) {
            Storage::delete($existingImagePath);
        }

        return $request->file('image')->store('images/blogs', 'public');
    }

    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        $imagePath = $this->updateImage($request, $blog);

        try {
            $this->updateBlogUseCase->execute(
                $blog->id,
                $request['title'],
                $request['content'],
                $imagePath ?? $blog->getImagePath(),
                $request['categories']
            );

            $blog->categories()->sync($request['categories']);

            return redirect()->route('admin.blogDetail', ['id' => $blog->id])->with('update_success', 'ブログを更新しました。');
        } catch (\Exception $e) {
            return back()->withErrors(['update_error' => $e->getMessage()]);
        }
    }

    // ブログ削除
    public function destroy(Blog $blog)
    {
        $blog->delete();

        return redirect()->route('admin.blogLists', $blog->id)->with('delete_success', 'ブログを削除しました。');
    }
}
