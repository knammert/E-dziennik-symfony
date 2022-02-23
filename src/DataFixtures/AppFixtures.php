<?php

namespace App\DataFixtures;

use App\Entity\ClassNames;
use Faker\Factory;
use App\Entity\Users;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $xd = new ClassNames();
        $xd->setName('1A');
        $manager->persist($xd);
        // $product = new Product();
        // $manager->persist($product);
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 20; $i++) {
            $user = new Users();
            $user->setName($faker->firstName());
            $user->setSurname($faker->lastName());
            $user->setEmail($faker->email());
            $user->setPassword('xd');
            $user->setPesel(rand(pow(10, 9-1), pow(10, 9)-1));

            $user->setClassName($xd);
            $manager->persist($user);
            $manager->flush();
        }

        $xd = new ClassNames();
        $xd->setName('2B');
        $manager->persist($xd);
        for ($i = 0; $i < 20; $i++) {
            $user = new Users();
            $user->setName($faker->firstName());
            $user->setSurname($faker->lastName());
            $user->setEmail($faker->email());
            $user->setPassword('xd');
            $user->setPesel(rand(pow(10, 9-1), pow(10, 9)-1));      
            $manager->persist($xd);
            $user->setClassName($xd);
            $manager->persist($user);
            $manager->flush();
        }

       
    }
}
