<?php

namespace App\Entity;

use App\Entity\Challenge\ChallengeParticipation;
use App\Entity\Challenge\ChallengeParticipationVote;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=ProfileRepository::class)
 * @UniqueEntity(fields={"pseudo"}, message="user_register.constraint.unique_pseudo")
 */
class Profile
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="profile", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $birthdate;

    /**
     * @ORM\Column(type="string", length=32, nullable=false, unique=true)
     */
    private $pseudo;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=ChallengeParticipation::class, mappedBy="profile")
     */
    private $challengeParticipations;

    /**
     * @ORM\OneToMany(targetEntity=ChallengeParticipationVote::class, mappedBy="profile")
     */
    private $challengeParticipationVotes;

    public function __construct()
    {
        $this->challengeParticipations = new ArrayCollection();
        $this->challengeParticipationVotes = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->pseudo;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(?\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(?string $pseudo): self
    {
        $this->pseudo = $pseudo;

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
            $challengeParticipation->setProfile($this);
        }

        return $this;
    }

    public function removeChallengeParticipation(ChallengeParticipation $challengeParticipation): self
    {
        if ($this->challengeParticipations->removeElement($challengeParticipation)) {
            // set the owning side to null (unless already changed)
            if ($challengeParticipation->getProfile() === $this) {
                $challengeParticipation->setProfile(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ChallengeParticipationVote[]
     */
    public function getChallengeParticipationVotes(): Collection
    {
        return $this->challengeParticipationVotes;
    }

    public function addChallengeParticipationVote(ChallengeParticipationVote $challengeParticipationVote): self
    {
        if (!$this->challengeParticipationVotes->contains($challengeParticipationVote)) {
            $this->challengeParticipationVotes[] = $challengeParticipationVote;
            $challengeParticipationVote->setProfile($this);
        }

        return $this;
    }

    public function removeChallengeParticipationVote(ChallengeParticipationVote $challengeParticipationVote): self
    {
        if ($this->challengeParticipationVotes->removeElement($challengeParticipationVote)) {
            // set the owning side to null (unless already changed)
            if ($challengeParticipationVote->getProfile() === $this) {
                $challengeParticipationVote->setProfile(null);
            }
        }

        return $this;
    }
}
