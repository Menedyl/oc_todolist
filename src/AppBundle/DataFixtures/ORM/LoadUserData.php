<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;


/**
 * Created by PhpStorm.
 * User: Menedyl
 * Date: 10/10/2017
 * Time: 16:43
 */
class LoadUserData extends Fixture
{

    public function load(ObjectManager $manager)
    {
        /** @var PasswordEncoderInterface $encoder */
        $encoder = $this->container->get('security.password_encoder');

        $user1 = new User();
        $user1->setUsername('Mickael');
        $user1->setEmail('mickael@gmail.com');
        $user1->setPassword($encoder->encodePassword($user1, 'test'));
        $user1->setRoles('ROLE_USER');

        $user2 = new User();
        $user2->setUsername('Nicolas');
        $user2->setEmail('nicolas@gmail.com');
        $user2->setPassword($encoder->encodePassword($user2, 'test'));
        $user2->setRoles('ROLE_ADMIN');


        $manager->persist($user1);
        $manager->persist($user2);
        $manager->flush();
    }

}
