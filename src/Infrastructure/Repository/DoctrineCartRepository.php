<?php

namespace App\Infrastructure\Repository;

use Doctrine\ORM\EntityRepository;
use App\Domain\Model\Cart;
use App\Domain\Repository\CartRepositoryInterface;

// class DoctrineCartRepository extends EntityRepository implements CartRepositoryInterface
// {
//     public function findByUserId($userId): ?Cart
//     {
//         return $this->getEntityManager()->getRepository(Cart::class)->findOneBy(['userId' => $userId]);
//     }

//     public function save(Cart $cart): void
//     {
//         $em = $this->getEntityManager();
//         $em->persist($cart);
//         $em->flush();
//     }

//     public function remove(Cart $cart): void
//     {
//         $em = $this->getEntityManager();
//         $em->remove($cart);
//         $em->flush();
//     }
// }
