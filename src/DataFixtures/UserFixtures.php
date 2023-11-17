<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\User;
use App\Factory\UserFactory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class UserFixtures extends Fixture
{

    public function __construct(
        private readonly UserFactory $userFactory
    ) {}

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $manager->persist($this->generateAdminUser());

        $manager->persist($this->generateTechnicienUser());

        for ($i = 0; $i < 10; $i++) {
            $manager->persist($this->generateUser($faker));
        }

        $manager->flush();
    }

    private function generateAdminUser(): User
    {
        return $this->userFactory->createUser(
            'admin',
            'admin',
            'ROLE_ADMIN',
        );
    }

    private function generateTechnicienUser(): User
    {
        return $this->userFactory->createUser(
            'technicien',
            'technicien',
        );
    }

    private function generateUser(Generator $faker): User
    {
        return $this->userFactory->createUser(
            $faker->userName(),
            $faker->password(),
        );
    }
  }
