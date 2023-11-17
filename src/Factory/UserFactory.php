<?php

namespace App\Factory;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface as PasswordHasher;

class UserFactory
{
    public function __construct(
        private readonly PasswordHasher $passwordHasher,
    ) {}

    public function createUser(
        string $username,
        string $password,
        string $role = 'ROLE_USER',
    ): User
    {
        $user = new User();

        $user->setUsername($username)
            ->setPassword($this->passwordHasher->hashPassword($user, $password))
            ->addRole($role)
        ;

        return $user;
    }
}
