<?php

namespace  App\DDD\Auth\UseCase;

use App\DDD\Auth\Domain\Entity\Admin;
use App\DDD\Auth\Domain\Repository\AdminRepositoryInterface;
use App\DDD\Auth\Domain\ValueObject\Password;

class RegisterAdminUseCase
{
  private $adminRepository;

  public function __construct(AdminRepositoryInterface $adminRepository)
  {
    $this->adminRepository = $adminRepository;
  }

  public function execute(string $name, string $email, string $password)
  {
    $passwordValueObject = new Password($password);
    $admin = new Admin($name, $email, $passwordValueObject);

    $this->adminRepository->create($admin);
  }
}
