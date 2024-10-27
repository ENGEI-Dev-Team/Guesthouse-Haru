<?php
namespace App\DDD\Comment\Domain\Repository;

use App\DDD\Comment\Domain\Entity\Comment;

interface CommentRepositoryInterface
{
  public function create(Comment $comment);
  public function delete($id);
  public function findById($id);
}