<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = (new User())
            ->setUsername("admin")
            ->setPassword('$2y$13$QgLfBXU3cQI4pDh20Br2WOfmNy4XCy0xDCU0ZwLtsGeQq3Y0Y2.x2')
            ->setRoles(["ROLE_ADMIN"]);
        $manager->persist($user);

        $user = (new User())
            ->setUsername("manager")
            ->setPassword('$2y$13$Sn4t6W/gNyq11i7utWW.Yuun9M5mbkmtDfOEMxrq8UooRgrYWv3kC')
            ->setRoles(["ROLE_MANAGER"]);
        $manager->persist($user);
        $manager->flush();
    }
}
