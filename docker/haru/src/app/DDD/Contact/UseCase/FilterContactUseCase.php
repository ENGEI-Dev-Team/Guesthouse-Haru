<?php
namespace App\DDD\Contact\UseCase;

use App\DDD\Contact\Domain\Repositories\ContactRepositoryInterface;

class FilterContactUseCase
{
  private $contactRepository;

  public function __construct(ContactRepositoryInterface $contactRepository)
  {
    $this->contactRepository = $contactRepository;
  }

  public function execute(array $filters)
  {
    return $this->contactRepository->filterContact($filters);
  }
}