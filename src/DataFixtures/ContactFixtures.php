<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Contact;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;

class ContactFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $manager->persist($this->generateContact($faker));
        }


        $manager->flush();
    }

    private function generateContact(Generator $faker): Contact
    {
        return (new Contact())->setNom($faker->lastName())
            ->setPrenom($faker->firstName())
            ->setEmail($faker->email())
            ->setTelephone($faker->phoneNumber())
        ;
    }
}
