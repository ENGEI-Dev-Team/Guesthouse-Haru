<?php

namespace App\DDD\Contact\Infrastructure;

use App\DDD\Contact\Domain\Entities\Contact as ContactEntity;
use App\DDD\Contact\Domain\Repositories\ContactRepositoryInterface;
use App\DDD\Contact\Domain\ValueObject\Email;
use App\Models\Contact;
use DateTime;

class EloquentContactRepository implements ContactRepositoryInterface
{
  public function save(ContactEntity $contact): void
  {
    $contactModel = new Contact();

    $contactModel->name = $contact->getName();
    $contactModel->email = $contact->getEmail()->getValue();;
    $contactModel->message = $contact->getMessage();
    $contactModel->status = $contact->getStatus();

    $contactModel->save();
  }

  public function findById(string $id): ?ContactEntity
  {
    $contactModel = Contact::find($id);

    if (!$contactModel) {
      return null;
    }

    return new ContactEntity(
      $contactModel->id,
      $contactModel->name,
      new Email($contactModel->email),
      $contactModel->message,
      $contactModel->status,
      new DateTime($contactModel->created_at)
    );
  }

  public function filterContact(array $filters)
  {
    $query = Contact::query();

    if (!empty($filters['name'])) {
      $query->where('name', 'like', '%' . $filters['name'] . '%');
    }

    if (!empty($filters['email'])) {
      $query->where('email', 'like', '%' . $filters['email'] . '%');
    }

    if (!empty($filters['status'])) {
      $query->where('status', $filters['status']);
    }

    if (!empty($filters['date_from']) && !empty($filters['date_to'])) {
      $query->whereBetween('created_at', [$filters['date_from'], $filters['date_to']]);
    }

    if (!empty($filters['message'])) {
      $query->where('message', 'like', '%' . $filters['message'] . '%');
    }

    return $query->paginate(10);
  }

  public function filterByStatus(array $statuses)
  {
    return Contact::whereIn('status', $statuses)->get();
  }

  public function deleteById(string $id): void
  {
    $contact = Contact::find($id);

    if ($contact) {
      $contact->delete();
    }
  }
}
