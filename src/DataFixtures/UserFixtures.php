<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;


    public function __construct(UserPasswordHasherInterface $passwordHasher)

    {

        $this->passwordHasher = $passwordHasher;

    }



    public function load(ObjectManager $manager): void

    {

        // Création d’un utilisateur de type “contributeur” (= auteur)

        $user = new User();
        $user->setEmail('john.doe@gmail.com');
        $user->setFirstname('John');
        $user->setLastname('Doe');
        $user->setRoles(['ROLE_USER']);

        $hashedPassword = $this->passwordHasher->hashPassword(

            $user,

            'john'

        );


        $user->setPassword($hashedPassword);

        $manager->persist($user);


        // Création d’un utilisateur de type “administrateur”

        $admin = new User();

        $admin->setEmail('admin@monsite.com');
        $admin->setFirstname('Admin');
        $admin->setLastname('Doe');
        $admin->setRoles(['ROLE_ADMIN']);

        $hashedPassword = $this->passwordHasher->hashPassword(

            $admin,

            'admin'

        );

        $admin->setPassword($hashedPassword);

        $manager->persist($admin);


        // Sauvegarde des 2 nouveaux utilisateurs :

        $manager->flush();

    }

}
