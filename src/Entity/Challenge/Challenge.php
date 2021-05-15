<?php

namespace App\Entity\Challenge;

use App\Repository\Challenge\ChallengeRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChallengeRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Challenge
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $displayAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $hideAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $participationStartsAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $participationEndsAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $voteBeginsAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $voteEndsAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $deliberationAt;

    /**
     * @ORM\OneToMany(targetEntity=ChallengeTranslation::class, mappedBy="challenge", orphanRemoval=true)
     */
    private $challengeTranslations;

    /**
     * @ORM\OneToMany(targetEntity=ChallengeParticipation::class, mappedBy="challenge")
     */
    private $challengeParticipations;

    public function __construct()
    {
        $this->challengeTranslations = new ArrayCollection();
        $this->challengeParticipations = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @ORM\PrePersist
     *
     * @return self
     */
    public function setCreatedAt(): self
    {
        $this->createdAt = new DateTime('now');

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @ORM\PreUpdate
     *
     * @return self
     */
    public function setUpdatedAt(): self
    {
        $this->updatedAt = new DateTime('now');

        return $this;
    }

    public function getDisplayAt(): ?\DateTimeInterface
    {
        return $this->displayAt;
    }

    public function setDisplayAt(\DateTimeInterface $displayAt): self
    {
        $this->displayAt = $displayAt;

        return $this;
    }

    public function getHideAt(): ?\DateTimeInterface
    {
        return $this->hideAt;
    }

    public function setHideAt(?\DateTimeInterface $hideAt): self
    {
        $this->hideAt = $hideAt;

        return $this;
    }

    public function getParticipationStartsAt(): ?\DateTimeInterface
    {
        return $this->participationStartsAt;
    }

    public function setParticipationStartsAt(\DateTimeInterface $participationStartsAt): self
    {
        $this->participationStartsAt = $participationStartsAt;

        return $this;
    }

    public function getParticipationEndsAt(): ?\DateTimeInterface
    {
        return $this->participationEndsAt;
    }

    public function setParticipationEndsAt(\DateTimeInterface $participationEndsAt): self
    {
        $this->participationEndsAt = $participationEndsAt;

        return $this;
    }

    public function getVoteBeginsAt(): ?\DateTimeInterface
    {
        return $this->voteBeginsAt;
    }

    public function setVoteBeginsAt(\DateTimeInterface $voteBeginsAt): self
    {
        $this->voteBeginsAt = $voteBeginsAt;

        return $this;
    }

    public function getVoteEndsAt(): ?\DateTimeInterface
    {
        return $this->voteEndsAt;
    }

    public function setVoteEndsAt(\DateTimeInterface $voteEndsAt): self
    {
        $this->voteEndsAt = $voteEndsAt;

        return $this;
    }

    public function getDeliberationAt(): ?\DateTimeInterface
    {
        return $this->deliberationAt;
    }

    public function setDeliberationAt(\DateTimeInterface $deliberationAt): self
    {
        $this->deliberationAt = $deliberationAt;

        return $this;
    }

    /**
     * @return Collection|ChallengeTranslation[]
     */
    public function getChallengeTranslations(): Collection
    {
        return $this->challengeTranslations;
    }

    public function addChallengeTranslation(ChallengeTranslation $challengeTranslation): self
    {
        if (!$this->challengeTranslations->contains($challengeTranslation)) {
            $this->challengeTranslations[] = $challengeTranslation;
            $challengeTranslation->setChallenge($this);
        }

        return $this;
    }

    public function removeChallengeTranslation(ChallengeTranslation $challengeTranslation): self
    {
        if ($this->challengeTranslations->removeElement($challengeTranslation)) {
            // set the owning side to null (unless already changed)
            if ($challengeTranslation->getChallenge() === $this) {
                $challengeTranslation->setChallenge(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ChallengeParticipation[]
     */
    public function getChallengeParticipations(): Collection
    {
        return $this->challengeParticipations;
    }

    public function addChallengeParticipation(ChallengeParticipation $challengeParticipation): self
    {
        if (!$this->challengeParticipations->contains($challengeParticipation)) {
            $this->challengeParticipations[] = $challengeParticipation;
            $challengeParticipation->setChallenge($this);
        }

        return $this;
    }

    public function removeChallengeParticipation(ChallengeParticipation $challengeParticipation): self
    {
        if ($this->challengeParticipations->removeElement($challengeParticipation)) {
            // set the owning side to null (unless already changed)
            if ($challengeParticipation->getChallenge() === $this) {
                $challengeParticipation->setChallenge(null);
            }
        }

        return $this;
    }
}
