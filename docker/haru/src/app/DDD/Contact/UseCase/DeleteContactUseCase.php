<?php
namespace App\DDD\Contact\UseCase;

use App\DDD\Contact\Domain\Repositories\ContactRepositoryInterface;

class DeleteContactUseCase
{
  private $contactRepository;

  public function __construct(ContactRepositoryInterface $contactRepository)
  {
    $this->contactRepository = $contactRepository;
  }

  public function execute(string $id): void
  {
    $this->contactRepository->DeleteById($id);
  }
}