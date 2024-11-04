<?php

namespace App\DDD\Blog\Infrastructure;

use App\DDD\Blog\Domain\Entity\Blog;
use App\DDD\Blog\Domain\Repository\BlogRepositoryInterface;
use App\Models\Blog as BlogModel;
use Illuminate\Pagination\LengthAwarePaginator;

class BlogRepository implements BlogRepositoryInterface
{
  public function save(Blog $blog): void
  {
    $blogModel = new BlogModel();
    $blogModel->admin_id = $blog->getAdminId();
    $blogModel->title = $blog->getTitle();
    $blogModel->content = $blog->getContent();
    $blogModel->image = $blog->getImagePath();
    $blogModel->save();

    $blogModel->categories()->sync($blog->getCategoryIds());
  }

  public function getAllBlogs(array $filters, int $perPage): LengthAwarePaginator
  {
    $query = BlogModel::query();

    // キーワード検索
    if (!empty($filters['keyword'])) {
      $query->where('title', 'like', '%' . $filters['keyword'] . '%')
        ->orWhere('content', 'like', '%' . $filters['keyword'] . '%');
    }

    // カテゴリー検索
    if (!empty($filters['category'])) {
      $query->whereHas('categories', function ($categoryQuery) use ($filters) {
        $categoryQuery->where('category_id', $filters['category']);
      });
    }

    // 並び順
    $order = $filters['order'] ?? 'newest';
    $orderDirection = 'desc';

    if ($order === 'newest') {
      $orderDirection = 'desc';
    } elseif ($order === 'oldest') {
      $orderDirection = 'asc';
    }

    $query->orderBy('created_at', $orderDirection);

    return $query->with('categories')->paginate($perPage);
  }

  public function findById($id)
  {
    $blogModel = BlogModel::find($id);
    if (!$blogModel) {
      return null;
    }

    return new Blog(
      $blogModel->id,
      $blogModel->admin_id,
      $blogModel->title,
      $blogModel->content,
      $blogModel->image,
      $blogModel->categories()->pluck('category_id')->toArray()
    );
  }

  public function update(Blog $blog): void
  {
    $blogModel = BlogModel::find($blog->getId());

    $blogModel->title = $blog->getTitle();
    $blogModel->content = $blog->getContent();
    $blogModel->image = $blog->getImagePath();
    $blogModel->save();

    $blogModel->categories()->sync($blog->getCategoryIds());
  }
}
