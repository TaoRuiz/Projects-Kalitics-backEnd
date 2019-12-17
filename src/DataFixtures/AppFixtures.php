<?php

namespace App\DataFixtures;

use App\Entity\Position;
use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');
        $roles = [];
        $positions = [];
        $users = [];

        /** CREATION DES ROLES */
        $nbRoles = $faker->numberBetween(20, 25);

        for ($rI = 0; $rI < $nbRoles; $rI++) {
            $role = new Role;
            $role->setTitle("r{$rI}");
            $roles[] = $role;
            $manager->persist($role);
        }



        /** CREATION DES POSITIONS */
        $nbPositions = $faker->numberBetween(8, 12);

        for ($pI = 0; $pI < $nbPositions; $pI++) {
            $position = new Position;
            $position->setTitle($faker->jobTitle);


            /** Choix des Roles pour cette Position, entre 1 et 4 */
            $rolesForThisPosition = $faker->randomElements($roles, $faker->numberBetween(2, 5));
            /** Ajout des rôles */
            foreach ($rolesForThisPosition as $pickedRole) {
                $position->addRole($pickedRole);
            }

            $manager->persist($position);



            /** CREATION DES USERS */
            $nbUsers = $faker->numberBetween(1, 3);
            for ($uI = 0; $uI < $nbUsers; $uI++) {
                $user = new User;
                $gender = $faker->randomElement(['female', 'male']);
                $user->setFirstName($faker->firstName($gender))
                    ->setLastName($faker->lastName)
                    ->setAvatar($gender . '_' . $faker->numberBetween(1, 4) . '.png')
                    ->setPosition($position);

                /** Génère une adresse mail à partir du nom et prénom de l'utilisateur en MINUSCULE, sans espace */
                $email = str_replace(' ', '_', mb_strtolower($user->getFirstName() . $user->getLastName()) . '@nomail.com');
                $user->setEmail($email);

                foreach ($rolesForThisPosition as $pickedRole) {
                    $user->addRole($pickedRole);
                }

                $manager->persist($user);
            }
        }
        $manager->flush();
    }
}
