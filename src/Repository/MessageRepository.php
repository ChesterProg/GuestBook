<?php

namespace App\Repository;

use App\Entity\Message;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * MessageRepository class
 *
 * This class is responsible for accessing and manipulating Message entities in the database.
 * It extends the ServiceEntityRepository to leverage Doctrine's built-in methods.
 *
 * @extends ServiceEntityRepository<Message>
 *
 * @method Message|null find($id, $lockMode = null, $lockVersion = null)
 * @method Message|null findOneBy(array $criteria, array $orderBy = null)
 * @method Message[]    findAll()
 * @method Message[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository extends ServiceEntityRepository
{
	/**
	 * MessageRepository constructor.
	 *
	 * @param ManagerRegistry $registry The registry to manage the entity
	 */
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, Message::class);
	}

	/**
	 * Retrieves a paginated list of messages, ordered by creation date.
	 *
	 * @param int $page The current page number (1-indexed)
	 * @param int $limit The number of messages per page
	 * @return Message[] Returns an array of Message entities
	 */
	public function findAllMessagesPaginated(int $page, int $limit): array
	{
		// Create a query builder for the Message entity
		$queryBuilder = $this->createQueryBuilder('m')
			->orderBy('m.created_at', 'DESC') // Order messages by creation date (latest first).
			->setFirstResult(($page - 1) * $limit) // Set the offset for pagination.
			->setMaxResults($limit); // Limit the number of results.

		// Execute the query and return the results
		return $queryBuilder->getQuery()->getResult();
	}
}