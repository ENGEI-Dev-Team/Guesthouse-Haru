<?php
namespace App\DDD\Blog\UseCase;

use App\DDD\Blog\Domain\Entity\Blog;
use App\DDD\Blog\Domain\Repository\BlogRepositoryInterface;

class UpdateBlogUseCase
{
  private $blogRepository;

  public function __construct(BlogRepositoryInterface $blogRepository)
  {
    $this->blogRepository = $blogRepository;
  }

  public function execute(string $id, String $title, string $content, string $imagePath, array $categoryIds)
  {
    $blog = $this->blogRepository->findById($id);

    $blog->update($title, $content, $imagePath, $categoryIds);
    $this->blogRepository->update($blog);
  }
}