<?php
namespace App\DDD\Auth\Domain\Entity;

use App\DDD\Auth\Domain\ValueObject\Password;

class Admin
{
  private string $name;
  private string $email;
  private Password $password;

  public function __construct(string $name, string $email, Password $password)
  {
    $this->name = $name;
    $this->email = $email;
    $this->password = $password;
  }

  public function getName(): string 
  {
    return $this->name;
  }

  public function getEmail(): string 
  {
    return $this->email;
  }

  public function getPassword(): Password
  {
    return $this->password;
  }
}