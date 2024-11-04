<?php
namespace App\DDD\Blog\UseCase;

use App\DDD\Blog\Domain\Repository\BlogRepositoryInterface;

class GetBlogsUseCase
{
  private $blogRepository;
  private const DEFAULT_PER_PAGE = 9;

  public function __construct(BlogRepositoryInterface $blogRepository)
  {
    $this->blogRepository = $blogRepository;
  }

  public function execute(array $filters, int $perPage = self::DEFAULT_PER_PAGE)
  {
    return $this->blogRepository->getAllBlogs($filters, $perPage);
  }
}