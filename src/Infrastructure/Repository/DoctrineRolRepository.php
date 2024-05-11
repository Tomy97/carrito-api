<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\Rol;
use App\Domain\Repository\RolRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DoctrineRolRepository extends EntityRepository implements RolRepositoryInterface
{
    private EntityManagerInterface $entityManager;
    private EntityRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Rol::class);
    }

    public function getRol(int $id): Rol
    {
        return $this->repository->find($id);
    }
}