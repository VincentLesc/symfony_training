<?php

namespace App\Entity\Challenge;

use App\Entity\Profile;
use App\Repository\Challenge\ChallengeParticipationVoteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChallengeParticipationVoteRepository::class)
 */
class ChallengeParticipationVote
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=ChallengeParticipation::class, inversedBy="votes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $participation;

    /**
     * @ORM\ManyToOne(targetEntity=Profile::class, inversedBy="challengeParticipationVotes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $profile;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getParticipation(): ?ChallengeParticipation
    {
        return $this->participation;
    }

    public function setParticipation(?ChallengeParticipation $participation): self
    {
        $this->participation = $participation;

        return $this;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(?Profile $profile): self
    {
        $this->profile = $profile;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
