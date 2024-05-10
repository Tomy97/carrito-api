<?php

namespace App\Domain\Repository;

use App\Domain\Model\Rol;

interface RolRepositoryInterface
{
    public function setRol(int $id): Rol;
}
