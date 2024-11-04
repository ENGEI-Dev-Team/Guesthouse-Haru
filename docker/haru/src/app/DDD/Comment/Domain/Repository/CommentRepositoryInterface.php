<?php
namespace App\DDD\Comment\Domain\Repository;

use App\DDD\Comment\Domain\Entity\Comment;

interface CommentRepositoryInterface
{
  public function create(Comment $comment);
  public function delete(string $id): void;
  public function findById(string $id);
}