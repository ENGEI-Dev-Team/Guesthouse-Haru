<?php
namespace  App\DDD\Auth\UseCase;

use App\DDD\Auth\Domain\Repository\AdminRepositoryInterface;
use App\DDD\Auth\Domain\ValueObject\Password;
use Illuminate\Support\Facades\Auth;


class LoginAdminUseCase
{
  public function execute($email, $password):bool
  {
    $passwordValueObject = new Password($password);
    $loginData = [
      'email' => $email, 
      'password' => $passwordValueObject->getValue()
    ];

    if (Auth::guard('admin')->attempt($loginData)) {
      return true;
    }

    return false;
  }
}