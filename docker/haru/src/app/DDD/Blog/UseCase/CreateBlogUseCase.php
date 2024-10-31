<?php

namespace App\DDD\Blog\UseCase;

use App\DDD\Blog\Domain\Entity\Blog as BlogEntity;
use App\DDD\Blog\Domain\Repository\BlogRepositoryInterface;

class CreateBlogUseCase
{
  private $blogRepository;

  public function __construct(BlogRepositoryInterface $blogRepository)
  {
    $this->blogRepository = $blogRepository;
  }

  public function execute(string $adminId, String $title, string $content, string $imagePath, array $categoryIds): void
  {
    $blogEntity = new BlogEntity(
      null,
      $adminId,
      $title,
      $content,
      $imagePath,
      $categoryIds
    );

    $this->blogRepository->save($blogEntity);
  }
}
