<?php

namespace App\DDD\Blog\Domain\Entity;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Blog
{
  private string $id;
  private string $adminId;
  private string $title;
  private string $content;
  private string $imagePath;
  private array $categoryIds;

  public function __construct(?string $id, string $adminId, string $title, string $content, string $imagePath, array $categoryIds)
  {
    $this->id =$id ?? (string) Str::uuid();
    $this->adminId = $adminId;
    $this->title = $title;
    $this->content = $content;
    $this->imagePath = $imagePath;
    $this->categoryIds = $categoryIds;
  }

  public function update(string $title, string $content, string $imagePath, array $categoryIds)
  {
    if ($this->imagePath && $this->imagePath !== $imagePath) {
      Storage::delete($this->imagePath);
    }
    $this->title = $title;
    $this->content = $content;
    $this->imagePath = $imagePath;
    $this->categoryIds = $categoryIds;
  }

  public function getId(): string
  {
    return $this->id;
  }

  public function getAdminId(): string
  {
    return $this->adminId;
  }

  public function getTitle(): string
  {
    return $this->title;
  }

  public function getContent(): string
  {
    return $this->content;
  }

  public function getImagePath(): string
  {
    return $this->imagePath;
  }

  public function getCategoryIds(): array
  {
    return $this->categoryIds;
  }
}