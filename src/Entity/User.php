<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class User
 * Represents a user entity in the application that implements UserInterface and PasswordAuthenticatedUserInterface.
 *
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
	/**
	 * @var int|null The unique identifier of the user.
	 */
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	/**
	 * @var bool Indicates whether the user account is blocked.
	 */
	#[ORM\Column(type: 'boolean')]
	private bool $is_blocked = false;

	/**
	 * @var string|null The email address of the user (unique).
	 */
	#[ORM\Column(length: 180, unique: true)]
	private ?string $email = null;

	/**
	 * @var array The roles assigned to the user.
	 */
	#[ORM\Column]
	private array $roles = [];

	/**
	 * @var string|null The hashed password of the user.
	 */
	#[ORM\Column]
	private ?string $password = null;

	public function __construct()
	{
		// Set default role for the user
		$this->roles[] = 'ROLE_USER'; // Set ROLE_USER as default
	}

	/**
	 * Get the unique identifier of the user.
	 *
	 * @return int|null The user ID.
	 */
	public function getId(): ?int
	{
		return $this->id;
	}

	/**
	 * Get the email address of the user.
	 *
	 * @return string|null The email address.
	 */
	public function getEmail(): ?string
	{
		return $this->email;
	}

	/**
	 * Set the email address of the user.
	 *
	 * @param string $email The email address to set.
	 * @return static The current instance for method chaining.
	 */
	public function setEmail(string $email): static
	{
		$this->email = $email;
		return $this;
	}

	/**
	 * A visual identifier that represents this user.
	 *
	 * @see UserInterface
	 * @return string The user identifier (email).
	 */
	public function getUserIdentifier(): string
	{
		return (string) $this->email;
	}

	/**
	 * Get the roles assigned to the user.
	 *
	 * @see UserInterface
	 * @return array The roles of the user.
	 */
	public function getRoles(): array
	{
		return $this->roles;
	}

	/**
	 * Set the roles assigned to the user.
	 *
	 * @param array $roles The roles to set.
	 */
	public function setRoles(array $roles): void
	{
		$this->roles = $roles;
	}

	/**
	 * Get the hashed password of the user.
	 *
	 * @see PasswordAuthenticatedUserInterface
	 * @return string The user's password.
	 */
	public function getPassword(): string
	{
		return $this->password;
	}

	/**
	 * Set the hashed password of the user.
	 *
	 * @param string $password The password to set.
	 * @return static The current instance for method chaining.
	 */
	public function setPassword(string $password): static
	{
		$this->password = $password;
		return $this;
	}

	/**
	 * Check if the user account is blocked.
	 *
	 * @return bool True if the user is blocked, otherwise false.
	 */
	public function getIsBlocked(): bool
	{
		return $this->is_blocked;
	}

	/**
	 * Set the blocked status of the user.
	 *
	 * @param bool $is_blocked The blocked status to set.
	 * @return self The current instance for method chaining.
	 */
	public function setIsBlocked(bool $is_blocked): self
	{
		$this->is_blocked = $is_blocked;
		return $this;
	}

	/**
	 * Clear any temporary, sensitive data on the user.
	 *
	 * @see UserInterface
	 */
	public function eraseCredentials(): void
	{
		// If you store any temporary, sensitive data on the user, clear it here
		// e.g., $this->plainPassword = null;
	}
}