<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\Common\Annotations\Annotation\IgnoreAnnotation;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Message
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(length: 255)]
	#[Assert\NotBlank]
	#[Assert\Regex('/^[a-zA-Z0-9]+$/', message: 'Username can only contain letters and digits.')]
	private ?string $name = null;

	#[ORM\Column(length: 255)]
	#[Assert\NotBlank]
	#[Assert\Email]
	private ?string $email = null;

	#[ORM\Column(type: Types::TEXT)]
	#[Assert\NotBlank]
	#[Assert\Length(max: 1000)]
	private ?string $text = null;

	#[ORM\Column(length: 255, nullable: true)]
	#[Assert\Url]
	private ?string $homepage = null;

	#[ORM\Column(length: 255, nullable: true)]
	private ?string $image_path = null;

	#[ORM\Column]
	private ?bool $status = false;

	#[ORM\Column(type: Types::DATETIME_MUTABLE)]
	private ?\DateTimeInterface $created_at = null;

	#[ORM\Column(length: 255, nullable: true)]
	private ?string $ip_address = null;

	#[ORM\Column(length: 255, nullable: true)]
	private ?string $user_agent = null;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\User")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private User $user;

	// Getters and Setters...

	public function getUser(): ?User
	{
		return $this->user;
	}

	public function setUser(?User $user): self
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

	public function getIpAddress(): ?string
	{
	return $this->ip_address;
	}

	public function setIpAddress(?string $ip_address): static
	{
	$this->ip_address = $ip_address;
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