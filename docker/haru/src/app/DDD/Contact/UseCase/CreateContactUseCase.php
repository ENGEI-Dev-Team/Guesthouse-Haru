<?php
namespace App\DDD\Contact\UseCase;

use App\DDD\Contact\Domain\Entities\Contact;
use App\DDD\Contact\Domain\Repositories\ContactRepositoryInterface;
use App\DDD\Contact\Domain\ValueObject\Email;
use DateTime;
use Illuminate\Support\Facades\Mail;

class CreateContactUseCase
{
  private $contactRepository;

  public function __construct(ContactRepositoryInterface $contactRepository)
  {
    $this->contactRepository = $contactRepository;
  }

  public function execute(array $request)
  {
    $id = (string) \Illuminate\Support\Str::uuid(); 
    $createdAt = new DateTime();

    $contact = new Contact($id, $request['name'], new Email($request['email']), $request['message'], 'unresolved', $createdAt);
    $this->contactRepository->save($contact);

    Mail::send('emails.contact_notification', ['contact' => $contact], function ($message) {
      $message->to('haru.shimayado@gmail.com')
        ->subject('新しいお問い合わせがありました。');
    });
  }
}
