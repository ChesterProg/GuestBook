<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
				$user = new User();
				$user->setEmail('admin@admin.com');
				$user->setPassword('$2y$13$o0pHAdHjBUlAFeSaeU4mLuMHLQiGnlfAmSDUQRZUQOcbnpgHBA3dS');
				$user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);

				$manager->persist($user);

        $manager->flush();
    }
}
