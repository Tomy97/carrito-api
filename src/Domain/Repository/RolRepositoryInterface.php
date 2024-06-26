<?php

namespace App\Domain\Repository;

use App\Domain\Model\Rol;

interface RolRepositoryInterface
{
    public function getRol(int $id): Rol;
}
