<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;



class UserFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // on crée un nouvel utilisateur
        $user = new User();
        // on lui donne un nom
        $user->setUsername('demo');
        // mdp en dur
        $plaintextPassword = 'demo';

        // on hash le mdp
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        // on assigne le mot de passe hashé à l'instance de User
        $user->setPassword($hashedPassword);

        // on sauvregarde les données dans la BDD
        $manager->persist($user);
        $manager->flush();
    }
}
