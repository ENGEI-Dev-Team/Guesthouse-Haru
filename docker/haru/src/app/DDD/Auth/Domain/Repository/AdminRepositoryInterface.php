<?php
namespace App\DDD\Auth\Domain\Repository;

use App\DDD\Auth\Domain\Entity\Admin;

interface AdminRepositoryInterface
{
  public function create(Admin $admin);
}