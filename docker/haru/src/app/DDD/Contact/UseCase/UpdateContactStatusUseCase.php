<?php
namespace App\DDD\Contact\UseCase;

use App\DDD\Contact\Domain\Repositories\ContactRepositoryInterface;

class UpdateContactStatusUseCase
{
  private $contactRepository;

  public function __construct(ContactRepositoryInterface $contactRepository)
  {
    $this->contactRepository = $contactRepository;
  }

  public function execute(string $id, string $status)
  {
    $contact = $this->contactRepository->findById($id);

    if (!$contact) {
      throw new \Exception('Contact not found');
    }

    $contact->setStatus($status);
    $this->contactRepository->save($contact);
  }
}