<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\Cart;
use App\Domain\Repository\CartRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DoctrineCartRepository implements CartRepositoryInterface
{

    private EntityManagerInterface $entityManager;
    private EntityRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Cart::class);
    }

    public function save(Cart $cart): void
    {
        $this->entityManager->persist($cart);
        $this->entityManager->flush();
    }

    public function delete(Cart $cart): void
    {
        $this->entityManager->remove($cart);
        $this->entityManager->flush();
    }

    public function findByUserId($userId): Cart
    {
        $cart = $this->entityManager->getRepository(Cart::class)->findOneBy(['user' => $userId]);
        if (!$cart) {
            throw new \Exception("Cart not found for user id: $userId");
        }
        return $cart;
    }


    public function findOneBy(): Cart
    {
        return $this->findOneBy();
    }

    public function findAll(): array
    {
        return $this->findAll();
    }

    public function getProducts(): array
    {
        return $this->repository->getProducts();
    }

    public function addProduct($product): void
    {
        $this->repository->addProduct($product);
    }

    public function removeProduct($product): void
    {
        $this->repository->removeProduct($product);
    }

    public function getTotal(): float
    {
        return $this->repository->getTotal();
    }

    public function getId(): int
    {
        return $this->repository->getId();
    }

    public function findCartWithProducts(int $userId): Cart
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('c', 'cp', 'p')
            ->from(Cart::class, 'c')
            ->leftJoin('c.cartProducts', 'cp')  // Se asume que en Cart está definido cartProducts
            ->leftJoin('cp.product', 'p')       // CartProduct tiene una propiedad product
            ->where('c.user = :userId')
            ->setParameter('userId', $userId);

        return $qb->getQuery()->getOneOrNullResult();
    }
}
