<?php

namespace App\Domain\Repository;

use App\Domain\Model\Rol;
use App\Domain\Model\User;

interface UserRepositoryInterface
{
    public function save(User $user): void;
    public function find(int $id): ?User;
    public function findByEmail(string $email): ?User;
    public function setRol(int $id): ?Rol;

    public function findById(int $id): ?User;
}