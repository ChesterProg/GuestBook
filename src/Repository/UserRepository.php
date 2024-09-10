<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * UserRepository class
 *
 * This class is responsible for accessing and manipulating User entities in the database.
 * It extends the ServiceEntityRepository to leverage Doctrine's built-in methods
 * and implements PasswordUpgraderInterface for managing password upgrades.
 *
 * @extends ServiceEntityRepository<User>
 * @implements PasswordUpgraderInterface<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
	/**
	 * UserRepository constructor.
	 *
	 * @param ManagerRegistry $registry The registry to manage the entity
	 */
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, User::class);
	}

	/**
	 * Upgrades (rehashes) the user's password automatically over time.
	 *
	 * This method checks if the user is an instance of User and then updates the user's password.
	 *
	 * @param PasswordAuthenticatedUserInterface $user The user whose password is being upgraded
	 * @param string $newHashedPassword The new hashed password
	 * @throws UnsupportedUserException if the user is not an instance of User
	 */
	public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
	{
		// Ensure that the user is an instance of the User entity
		if (!$user instanceof User) {
			throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
		}

		// Set the new hashed password for the user
		$user->setPassword($newHashedPassword);

		// Persist the changes to the entity manager
		$this->getEntityManager()->persist($user);
		$this->getEntityManager()->flush();
	}
}