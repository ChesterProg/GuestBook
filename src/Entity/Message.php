<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Message
 * Represents a message entity in the application.
 *
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 */
#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Message
{
	/**
	 * @var int|null The unique identifier of the message.
	 */
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	/**
	 * @var string|null The name of the user sending the message.
	 *
	 * @Assert\NotBlank
	 * @Assert\Regex("/^[a-zA-Z0-9]+$/", message="Username can only contain letters and digits.")
	 */
	#[ORM\Column(length: 255)]
	#[Assert\NotBlank]
	#[Assert\Regex('/^[a-zA-Z0-9]+$/', message: 'Username can only contain letters and digits.')]
	private ?string $name = null;

	/**
	 * @var string|null The email address of the user.
	 *
	 * @Assert\NotBlank
	 * @Assert\Email
	 */
	#[ORM\Column(length: 255)]
	#[Assert\NotBlank]
	#[Assert\Email]
	private ?string $email = null;

	/**
	 * @var string|null The content of the message.
	 *
	 * @Assert\NotBlank
	 * @Assert\Length(max=1000)
	 */
	#[ORM\Column(type: Types::TEXT)]
	#[Assert\NotBlank]
	#[Assert\Length(max: 1000)]
	private ?string $text = null;

	/**
	 * @var string|null The homepage URL of the user.
	 *
	 * @Assert\Url
	 */
	#[ORM\Column(length: 255, nullable: true)]
	#[Assert\Url]
	private ?string $homepage = null;

	/**
	 * @var string|null The path to the image associated with the message.
	 */
	#[ORM\Column(length: 255, nullable: true)]
	private ?string $image_path = null;

	/**
	 * @var bool|null Indicates whether the message is approved.
	 */
	#[ORM\Column]
	private ?bool $status = false;

	/**
	 * @var \DateTimeInterface|null The date and time when the message was created.
	 */
	#[ORM\Column(type: 'datetime')]
	private ?\DateTimeInterface $created_at = null;

	/**
	 * @var string|null The user ID associated with the message.
	 */
	#[ORM\Column(type: "string", nullable: true)]
	private ?string $user_id = null;

	/**
	 * @var string|null The user agent string of the user who sent the message.
	 */
	#[ORM\Column(length: 255, nullable: true)]
	private ?string $user_agent = null;

	/**
	 * @var User The user entity associated with this message.
	 *
	 * @ORM\ManyToOne(targetEntity="App\Entity\User")
	 * @ORM\JoinColumn(nullable=false)
	 */
	#[ORM\ManyToOne(targetEntity: "App\Entity\User")]
	#[ORM\JoinColumn(nullable: false)]
	private User $user;

	// Getters and Setters...

	public function getUser(): ?User
	{
		return $this->user;
	}

	public function setUser(User $user): self
	{
		$this->user = $user;
		return $this;
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getName(): ?string
	{
		return $this->name;
	}

	public function setName(string $name): static
	{
		$this->name = $name;
		return $this;
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

	public function getHomepage(): ?string
	{
		return $this->homepage;
	}

	public function setHomepage(?string $homepage): static
	{
		$this->homepage = $homepage;
		return $this;
	}

	public function getText(): ?string
	{
		return $this->text;
	}

	public function setText(string $text): static
	{
		$this->text = $text;
		return $this;
	}

	public function getImagePath(): ?string
	{
		return $this->image_path;
	}

	public function setImagePath(?string $image_path): static
	{
		$this->image_path = $image_path;
		return $this;
	}

	public function getStatus(): ?bool
	{
		return $this->status;
	}

	public function setStatus(bool $status): static
	{
		$this->status = $status;
		return $this;
	}

	public function getCreatedAt(): ?\DateTimeInterface
	{
		return $this->created_at;
	}

	public function setCreatedAt(\DateTimeInterface $created_at): static
	{
		$this->created_at = $created_at;
		return $this;
	}

	public function getUserId(): ?string
	{
		return $this->user_id;
	}

	public function setUserId(string $user_id): static
	{
		$this->user_id = $user_id;
		return $this;
	}

	public function getUserAgent(): ?string
	{
		return $this->user_agent;
	}

	public function setUserAgent(?string $user_agent): static
	{
		$this->user_agent = $user_agent;
		return $this;
	}
}