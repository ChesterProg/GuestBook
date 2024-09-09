<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(type: 'boolean')]
	private bool $is_blocked = false;

	#[ORM\Column(length: 180, unique: true)]
	private ?string $email = null;

	#[ORM\Column]
	private array $roles = [];

	#[ORM\Column]
	private ?string $password = null;

	public function __construct()
	{
		// Set default role
		$this->roles[] = 'ROLE_USER'; // Set ROLE_USER as default
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getEmail(): ?string
	{
		return $this->email;
	}

	public function setEmail(string $email): static
	{
		$this->email = $email;

		return $this;
	}

	/**
	 * A visual identifier that represents this user.
	 *
	 * @see UserInterface
	 */
	public function getUserIdentifier(): string
	{
		return (string) $this->email;
	}

	/**
	 * @see UserInterface
	 */
	public function getRoles(): array
	{
		return $this->roles;
	}

	public function setRoles(array $roles): void
	{
		$this->roles = $roles;
	}

	/**
	 * @see PasswordAuthenticatedUserInterface
	 */
	public function getPassword(): string
	{
		return $this->password;
	}

	public function setPassword(string $password): static
	{
		$this->password = $password;
		return $this;
	}

	public function getIsBlocked(): bool
	{
		return $this->is_blocked;
	}

	public function setIsBlocked(bool $is_blocked): self
	{
		$this->is_blocked = $is_blocked;

		return $this;
	}

	/**
	 * @see UserInterface
	 */
	public function eraseCredentials(): void
	{
			// If you store any temporary, sensitive data on the user, clear it here
			// $this->plainPassword = null;
	}

}
