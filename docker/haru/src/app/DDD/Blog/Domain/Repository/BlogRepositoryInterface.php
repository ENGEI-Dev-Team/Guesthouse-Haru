<?php
namespace App\DDD\Blog\Domain\Repository;

use App\DDD\Blog\Domain\Entity\Blog;
use Illuminate\Pagination\LengthAwarePaginator;

interface BlogRepositoryInterface
{
  public function save(Blog $blog);
  public function getAllBlogs(array $filters, int $perPage): LengthAwarePaginator;
  public function findById($id);
  public function update(Blog $blog);
}