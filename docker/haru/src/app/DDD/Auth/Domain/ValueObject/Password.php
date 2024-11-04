<?php
namespace App\DDD\Auth\Domain\ValueObject;

class Password
{
  private $value;

  private const MIN_LENGTH = 6;
  private const LOWERCASE_REGEX = '/[a-z]/';
  private const UPPERCASE_REGEX = '/[A-Z]/';
  private const DIGIT_REGEX = '/[0-9]/';

  public function __construct(string $value)
  {
    if (strlen($value) < self::MIN_LENGTH) {
      throw new \InvalidArgumentException('Passwordは' . self::MIN_LENGTH . 'である必要があります');
    }

    if (!preg_match(self::LOWERCASE_REGEX, $value) ||
        !preg_match(self::UPPERCASE_REGEX, $value) || 
        !preg_match(self::DIGIT_REGEX, $value)) {
      throw new \InvalidArgumentException('Passwordには小文字、大文字、数字を含める必要があります');
    }

    $this->value = $value;
  }

  public function getValue()
  {
    return $this->value;
  }
}