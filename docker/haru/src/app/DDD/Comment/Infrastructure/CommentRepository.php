<?php
namespace App\DDD\Comment\Infrastructure;

use App\DDD\Comment\Domain\Entity\Comment;
use App\DDD\Comment\Domain\Repository\CommentRepositoryInterface;
use App\Models\Comment as CommentModel;

class CommentRepository implements CommentRepositoryInterface
{
  public function create(Comment $comment)
  {
    return CommentModel::create([
      'blog_id' => $comment->getBlogId(),
      'author' => $comment->getAuthor(),
      'content' => $comment->getContent(),
    ]);
  }

  public function delete($id)
  {
    $comment = CommentModel::find($id);
    if ($comment) {
      $comment->delete();
    }
  }

  public function findById($id)
  {
    return CommentModel::find($id);
  }
}