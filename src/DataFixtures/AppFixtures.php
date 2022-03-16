<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Users;
use App\Entity\Grades;
use App\Entity\ClassNames;
use App\Entity\ClassNameSubjects;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
//RANDOM USERS
        // $className1 = new ClassNames();
        // $className1->setName('1A');
        // $manager->persist($className1);
        // $manager->flush();

        // $className2 = new ClassNames();
        // $className2->setName('1B');
        // $manager->persist($className2);
        // $manager->flush();

        // $className3 = new ClassNames();
        // $className3->setName('2A');
        // $manager->persist($className3);
        // $manager->flush();

        // $className4 = new ClassNames();
        // $className4->setName('3A');
        // $manager->persist($className4);
        // $manager->flush();

        // $faker = \Faker\Factory::create();
        // for ($i = 0; $i < 20; $i++) {
        //     $user = new Users();
        //     $user->setName($faker->firstName());
        //     $user->setSurname($faker->lastName());
        //     $user->setEmail($faker->email());
        //     $user->setPassword('sdfdss92433sdjhsfdjh93284237423sdfnfsbd2112sdf');
        //     $user->setPesel(rand(pow(10, 9-1), pow(10, 9)-1));
        //     $user->setRoles(['ROLE_STUDENT']);
        //     $user->setClassName($className1);
        //     $manager->persist($user);
        //     $manager->flush();
        // }

        // for ($i = 0; $i < 20; $i++) {
        //     $user = new Users();
        //     $user->setName($faker->firstName());
        //     $user->setSurname($faker->lastName());
        //     $user->setEmail($faker->email());
        //     $user->setPassword('sdfdss92433sdjhsfdjh93284237423sdfnfsbd2112sdf');
        //     $user->setPesel(rand(pow(10, 9-1), pow(10, 9)-1));      
        //     $manager->persist($className2);
        //     $user->setClassName($className2);
        //     $user->setRoles(['ROLE_STUDENT']);
        //     $manager->persist($user);
        //     $manager->flush();
        // }
        
        // for ($i = 0; $i < 20; $i++) {
        //     $user = new Users();
        //     $user->setName($faker->firstName());
        //     $user->setSurname($faker->lastName());
        //     $user->setEmail($faker->email());
        //     $user->setPassword('sdfdss92433sdjhsfdjh93284237423sdfnfsbd2112sdf');
        //     $user->setPesel(rand(pow(10, 9-1), pow(10, 9)-1));      
        //     $manager->persist($className3);
        //     $user->setClassName($className3);
        //     $user->setRoles(['ROLE_STUDENT']);
        //     $manager->persist($user);
        //     $manager->flush();
        // }
        
        // for ($i = 0; $i < 20; $i++) {
        //     $user = new Users();
        //     $user->setName($faker->firstName());
        //     $user->setSurname($faker->lastName());
        //     $user->setEmail($faker->email());
        //     $user->setPassword('sdfdss92433sdjhsfdjh93284237423sdfnfsbd2112sdf');
        //     $user->setPesel(rand(pow(10, 9-1), pow(10, 9)-1));      
        //     $manager->persist($className4);
        //     $user->setClassName($className4);
        //     $user->setRoles(['ROLE_STUDENT']);
        //     $manager->persist($user);
        //     $manager->flush();
        // }

        // $faker = \Faker\Factory::create();
        // for ($i = 0; $i < 10; $i++) {
        //     $user = new Users();
        //     $user->setName($faker->firstName());
        //     $user->setSurname($faker->lastName());
        //     $user->setEmail($faker->email());
        //     $user->setPassword('sdfdss92433sdjhsfdjh93284237423sdfnfsbd2112sdf');
        //     $user->setPesel(rand(pow(10, 9-1), pow(10, 9)-1));
        //     $user->setRoles(['ROLE_TEACHER']);
        //     $manager->persist($user);
        //     $manager->flush();
        // }


// RANDOM GRADES
        // $users = $manager->getRepository(Users::class)->findBy([
        //     'class_name' => 1,
        // ]);

        // $activities = $manager->getRepository(ClassNameSubjects::class)->findBy([
        //     'id' => 39,
        // ]);
        // $random = array("1", "1.5", "1.75","2", "2.5", "2.75","3", "3.5", "3.75","4", "4.5", "4.75","5", "5.5", "5.75","6");
        // $randomComments = array("Sprawdzian", "Kartkówka", "Odpowiedź Ustna");
        // $faker = \Faker\Factory::create();
        // for ($i = 0; $i < 10; $i++) {
        //     $user = $users[array_rand($users)];
        //     $activity = $activities[array_rand($activities)];
        //     $randomGrade = $random[array_rand($random)];
        //     $randomWeight = $random[array_rand($random)];
        //     $randomComment = $randomComments[array_rand($randomComments)];

        //     $grade = new Grades();
        //     $grade->setUser($user);
        //     $grade->setClassNameSubject($activity);
        //     $grade->setGrade($randomGrade);
        //     $grade->setWeight($randomWeight);
        //     $grade->setComment($randomComment);
        //     $grade->setSemestr('1');
        //     $manager->persist($grade);
        //     $manager->flush();
        // }
// RANDOM SPECIFIC STUDENT GRADES
        $users = $manager->getRepository(Users::class)->findBy([
            'id' => 3,
        ]);

        $activities = $manager->getRepository(ClassNameSubjects::class)->findBy([
            'class_name' => 1,
        ]);
        $random = array("1", "1.5", "1.75","2", "2.5", "2.75","3", "3.5", "3.75","4", "4.5", "4.75","5", "5.5", "5.75","6");
        $randomComments = array("Sprawdzian", "Kartkówka", "Odpowiedź ustna");
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 25; $i++) {
            $user = $users[array_rand($users)];
            $activity = $activities[array_rand($activities)];
            $randomGrade = $random[array_rand($random)];
            $randomWeight = $random[array_rand($random)];
            $randomComment = $randomComments[array_rand($randomComments)];

            $grade = new Grades();
            $grade->setUser($user);
            $grade->setClassNameSubject($activity);
            $grade->setGrade($randomGrade);
            $grade->setWeight($randomWeight);
            $grade->setComment($randomComment);
            $grade->setSemestr('1');
            $manager->persist($grade);
            $manager->flush();
        }
    }
}
