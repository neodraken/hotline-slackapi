<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TicketRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Ticket
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $summary;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     * 
     */
    private $type;

    /**
     * @ORM\Column(type="datetime")
     * 
     */
    private $createdAt;

    const TYPE_PROBLEM = 0;
    const TYPE_INCIDENT = 1;
    const TYPE_TASK = 2;

    const LABEL_TYPES = [
        self::TYPE_PROBLEM => 'Problem',
        self::TYPE_INCIDENT => 'Incident',
        self::TYPE_TASK => 'Task',
    ];


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getType(): ?bool
    {
        return $this->type;
    }

    public function setType(bool $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @ORM\PrePersist
     *
     * @return void
     */
    public function setCreatedAtDateTimeValue(): void
    {
        $this->createdAt = new DateTime();
    }

    /**
     * Get label from type
     *
     * @return string
     */
    public function getLabelType(): string
    {
        return self::LABEL_TYPES[$this->getType()];
    }
}
