<?php
namespace App\DDD\Comment\UseCase;

use App\DDD\Comment\Domain\Entity\Comment;
use App\DDD\Comment\Domain\Repository\CommentRepositoryInterface;

class CreateCommentUseCase
{
  private $commentRepository;

  public function __construct(CommentRepositoryInterface $commentRepository)
  {
    $this->commentRepository = $commentRepository;
  }

  public function execute(array $data, $blogId)
  {
    $comment  = new Comment($blogId, $data['author'],$data['content']);
    $comment->validate();

    return $this->commentRepository->create($comment);
  }
}