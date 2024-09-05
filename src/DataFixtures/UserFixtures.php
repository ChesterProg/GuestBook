<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
				$user = new User();
				$user->setEmail('admin@admin.com');
				$user->setPassword('$2y$13$z1DNEAHbdz9wGGHTUP4BQeEaxFXINBRbpKDWmfkuAQeHHVT8wBvS');
				$user->setRoles(['ROLE_USER']);

				$manager->persist($user);

        $manager->flush();
    }
}
