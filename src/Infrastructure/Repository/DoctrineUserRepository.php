<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\Rol;
use App\Domain\Model\User;
use App\Domain\Repository\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DoctrineUserRepository implements UserRepositoryInterface
{
    private EntityManagerInterface $entityManager;
    private EntityRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(User::class);
    }


    public function save(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function find(int $id): ?User
    {
        return $this->repository->find($id);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->repository->findOneBy(['email' => $email]);
    }

    public function setRol(int $id): ?Rol
    {
        return $this->repository->find($id);
    }

    public function findById(int $id): ?User
    {
        return $this->repository->find($id);
    }

    public function getUser(int $id): ?User
    {
        return $this->repository->find($id);
    }

    public function getProducts(int $id): array
    {
        return $this->repository->getProducts();
    }

    public function getTotal(): float
    {
        return $this->repository->getTotal();
    }
}