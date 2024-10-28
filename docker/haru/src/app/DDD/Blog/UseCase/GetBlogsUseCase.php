<?php
namespace App\DDD\Blog\UseCase;

use App\DDD\Blog\Domain\Repository\BlogRepositoryInterface;

class GetBlogsUseCase
{
  private $blogRepository;

  public function __construct(BlogRepositoryInterface $blogRepository)
  {
    $this->blogRepository = $blogRepository;
  }

  public function execute(array $filters, int $perPage = 10)
  {
    return $this->blogRepository->getAllBlogs($filters, $perPage);
  }
}