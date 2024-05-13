<?php

namespace App\Application\Service;

use App\Domain\Model\Cart;
use App\Domain\Model\User;
use App\Domain\Repository\CartRepositoryInterface;
use App\Domain\Repository\RolRepositoryInterface;
use App\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    private UserRepositoryInterface $userRepository;
    private UserPasswordHasherInterface $passwordHasher;
    private RolRepositoryInterface $rolRepository;

    private CartRepositoryInterface $cartRepository;


    public function __construct(
        UserRepositoryInterface $userRepository,
        UserPasswordHasherInterface $passwordHasher,
        RolRepositoryInterface $rolRepository,
        CartRepositoryInterface $cartRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
        $this->rolRepository = $rolRepository;
        $this->cartRepository = $cartRepository;

    }

    public function registerUserService(string $email, string $password, string $name, ?string $rol = null): User
    {
        $user = new User();
        $user->setEmail($email);
        $user->setPassword($this->passwordHasher->hashPassword($user, $password));
        $user->setName($name);

        $cart = new Cart();
        $user->setCart($cart);

        if ($rol !== null && $rol === 'admin') {
            $rol = $this->rolRepository->getRol(1);
        } else {
            $rol = $this->rolRepository->getRol(2);
        }
        $user->setRol($rol);

        $this->cartRepository->save($cart);
        $this->userRepository->save($user);

        return $user;
    }

    public function loginUserService(string $email, string $password): bool
    {
        $user = $this->userRepository->findByEmail($email);
        if (!$user) {
            return false;
        }

        return $this->passwordHasher->isPasswordValid($user, $password);
    }

    public function getUserByEmail(string $email): ?User
    {
        return $this->userRepository->findByEmail($email);
    }
}