<?php

namespace App\DDD\Contact\Domain\Entities;

use App\DDD\Contact\Domain\ValueObject\Email;
use DateTime;
use InvalidArgumentException;

class Contact
{
  private string $id;
  private string $name;
  private Email $email;
  private string $message;
  private string $status;
  private $createdAt;

  public function __construct(string $id, string $name, Email $email, string $message, string $status = 'unresolved', DateTime $createdAt)
  {
    $this->id = $id;
    $this->name = $name;
    $this->email = $email;
    $this->message = $message;
    $this->setStatus($status);
    $this->createdAt = $createdAt;
  }

  public function getId(): string
  {
    return $this->id;
  }

  public function getName(): string
  {
    return $this->name;
  }

  public function getEmail(): Email
  {
    return $this->email;
  }

  public function getMessage(): string
  {
    return $this->message;
  }

  public function getStatus(): string
  {
    return $this->status;
  }

  public function setStatus(string $status)
  {
    if (!in_array($status, ['unresolved', 'in_progress', 'resolved']))
    {
      throw new InvalidArgumentException(('Invalid status value'));
    }
    $this->status = $status;
  }

  public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
