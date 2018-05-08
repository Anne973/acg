<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * Created by PhpStorm.
 * User: Anne
 * Date: 23/04/2018
 * Time: 16:37
 */
class AppFixtures extends Fixture
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        foreach ($this->getUserData() as [$username, $password, $email, $roles])
        {
            $user = new User();
            $user->setUsername($username);
            $user->setPassword($this->passwordEncoder->encodePassword($user, $password));
            $user->setEmail($email);
            $user->setRoles($roles);
            $manager->persist($user);

        }
        $manager->flush();
    }

    private function getUserData()
    {
        return [
            ['Admin', 'admin', 'ass-dep-anciens-combat@orange.fr', ['ROLE_ADMIN']],
            ['Fredy', 'april', 'fredy.lucas@hotmail.fr', ['ROLE_USER']],

        ];
    }
}
