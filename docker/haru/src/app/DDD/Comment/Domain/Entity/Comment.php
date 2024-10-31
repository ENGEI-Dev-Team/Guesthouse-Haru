<?php

namespace App\DDD\Comment\Domain\Entity;

class Comment
{
  private string $blogId;
  private string $author;
  private string $content;

  public function __construct(string $blogId, string $author, string $content)
  {
    $this->blogId = $blogId;
    $this->author = $author;
    $this->content = $content;
  }

  public function getBlogId(): string
  {
    return $this->blogId;
  }

  public function getAuthor(): string
  {
    return $this->author;
  }

  public function getContent(): string
  {
    return $this->content;
  }

  public function validate()
  {
    if (empty($this->author) || empty($this->content)) {
      throw new \InvalidArgumentException('Author and content cannot be empty.');
    }
  }
}
