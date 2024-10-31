<?php

namespace App\Http\Controllers;

use App\DDD\Blog\UseCase\CreateBlogUseCase;
use App\DDD\Blog\UseCase\GetBlogsUseCase;
use App\DDD\Blog\UseCase\UpdateBlogUseCase;
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
        if (!$request->hasFile('image')) {
            return back()->withErrors(['image' => '画像がアップロードされていません。'])->withInput();
        }
        $imagePath = $request->file('image')->store('images/blogs', 'public');

        $adminId = Auth::guard('admin')->id();

        $this->createBlogUseCase->execute(
            $adminId, 
            $validatedData['title'], 
            $validatedData['content'], 
            $imagePath,  
            $validatedData['categories']
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

    public function update(Request $request, Blog $blog)
    {
        $validatedData = $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,webp',
            'title' => 'required|string|max:255',
            'content' => 'required|string|',
            'categories' => 'required|array|min:1'
        ], [
            'image.image' => '画像は画像ファイルである必要があります。',
            'image.mimes' => '画像はjpeg、png、jpg、またはwebp形式である必要があります。',
            'title.required' => 'タイトルを入力してください。',
            'title.max' => 'タイトルは255文字以内でなければなりません。',
            'content.required' => '内容を入力してください。',
            'categories.required' => '少なくとも1つのカテゴリを選択してください。',
            'categories.min' => '少なくとも1つのカテゴリを選択してください。',
        ]);

        $imagePath = $this->updateImage($request, $blog);

        try {
            $this->updateBlogUseCase->execute(
                $blog->id,
                $validatedData['title'],
                $validatedData['content'],
                $imagePath ?? $blog->getImagePath(),
                $validatedData['categories']
            );

            $blog->categories()->sync($validatedData['categories']);

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
