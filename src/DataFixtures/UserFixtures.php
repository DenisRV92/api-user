<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('test@mail.com');
        $user->setAge(23);
        $user->setBirthday('20-01-2000');
        $user->setPhone(9537322232);
        $user->setName('Игорь');
        $user->setSex('м');
        $manager->persist($user);

        $user1 = new User();
        $user1->setEmail('google@mail.com');
        $user1->setAge(33);
        $user1->setBirthday('25-05-1990');
        $user1->setPhone(9887322247);
        $user1->setName('Елена');
        $user1->setSex('ж');
        $manager->persist($user1);

        $manager->flush();
    }
}
