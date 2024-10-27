<?php
namespace App\DDD\Comment\UseCase;

use App\DDD\Comment\Domain\Repository\CommentRepositoryInterface;

class DeleteCommentUseCase
{
  private $commentRepository;

  public function __construct(CommentRepositoryInterface $commentRepository)
  {
    $this->commentRepository = $commentRepository;
  }

  public function execute($id)
  {
    $this->commentRepository->delete($id);
  }
}