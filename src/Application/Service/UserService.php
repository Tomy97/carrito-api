<?php

namespace App\Application\Service;

use App\Domain\Model\User;
use App\Domain\Repository\RolRepositoryInterface;
use App\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    private UserRepositoryInterface $userRepository;
    private UserPasswordHasherInterface $passwordHasher;
    private RolRepositoryInterface $rolRepository;


    public function __construct(UserRepositoryInterface $userRepository, UserPasswordHasherInterface $passwordHasher, RolRepositoryInterface $rolRepository)
    {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
        $this->rolRepository = $rolRepository;
    }

    public function registerUserService(string $email, string $password, string $name): User
    {
        $user = new User();
        $user->setEmail($email);
        $user->setPassword($this->passwordHasher->hashPassword($user, $password));
        $user->setName($name);
        $this->rolRepository->setRol(2);

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
}