<?php
namespace App\DDD\Auth\Infrastructure;

use App\DDD\Auth\Domain\Repository\AdminRepositoryInterface;
use App\DDD\Auth\Domain\ValueObject\Password;
use App\DDD\Auth\Domain\Entity\Admin;
use App\Models\Admin as AdminModel;

class AdminRepository implements AdminRepositoryInterface
{
  public function create(Admin $admin)
  {
    AdminModel::create([
      'name' => $admin->getName(),
      'email' => $admin->getEmail(),
      'password' => $admin->getPassword()->getValue(),
    ]);
  }

  public function findByEmail(string $email): ?Admin
  {
    $adminModel = AdminModel::where('email', $email)->first();
    if (!$adminModel) {
      return null;
    }
    $password = new Password($adminModel->password);
    return new Admin($adminModel->name, $adminModel->email, $password);
    
    return $admin;
  }
}