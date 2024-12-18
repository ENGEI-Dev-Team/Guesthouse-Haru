<?php
namespace App\DDD\Contact\Domain\ValueObject;

use InvalidArgumentException;

class Email
{
  private $email;
  private const MAX_LENGTH = 255;

  public function __construct(string $email)
  {
    $this->validate($email);
    $this->email = $email;
  }

  public function validate(string $email): void
  {
    if (empty($email)) {
      throw new InvalidArgumentException("Email cannot be empty.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      throw new InvalidArgumentException("Invalid email format.");
    }

    if (strlen($email) > self::MAX_LENGTH) {
      throw new InvalidArgumentException("Email cannot exceed 255 characters");
    }
  }

  public function getValue(): string
  {
    return $this->email;
  }

  public function __toString()
    {
        return $this->email;
    }
}