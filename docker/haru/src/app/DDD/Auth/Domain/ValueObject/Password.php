<?php
namespace App\DDD\Auth\Domain\ValueObject;

class Password
{
  private $value;

  public function __construct(string $value)
  {
    if (strlen($value) < 6) {
      throw new \InvalidArgumentException('Passwordは6文字以上である必要があります');
    }

    if (!preg_match('/[a-z]/', $value) || !preg_match('/[A-Z]/', $value) || !preg_match('/[0-9]/', $value)) {
      throw new \InvalidArgumentException('Passwordには小文字、大文字、数字を含める必要があります');
    }

    $this->value = $value;
  }

  public function getValue()
  {
    return $this->value;
  }
}