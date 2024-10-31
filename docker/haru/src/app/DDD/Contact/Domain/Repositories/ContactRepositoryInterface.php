<?php
namespace App\DDD\Contact\Domain\Repositories;

use App\DDD\Contact\Domain\Entities\Contact;

interface ContactRepositoryInterface
{
  public function save(Contact $contact);
  public function findById(string $id): ?Contact;
  public function filterContact(array $filters);
  public function filterByStatus(array $statuses);
  public function deleteById(string $id);
}