<?php

namespace App\Entity\Challenge;

use App\Repository\Challenge\ChallengeRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ChallengeRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @Vich\Uploadable
 */
class Challenge
{
    public const DRAFT = 10;
    public const PUBLISHED = 20;
    public const PARTICIPATION = 30;
    public const VOTE = 40;
    public const WAIT_DELIBERATION = 50;
    public const DELIBERATED = 60;
    public const CLOSED = 70;

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

    /**
     * @ORM\Column(type="integer")
     */
    private $state;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="challenge", fileNameProperty="mainImageName")
     *
     * @var File|null
     */
    private $mainImageFile;

    /**
     * @ORM\Column(type="string")
     *
     * @var string|null
     */
    private $mainImageName;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxParticipationsPerProfile;

    public function __construct()
    {
        $this->challengeTranslations = new ArrayCollection();
        $this->challengeParticipations = new ArrayCollection();
        $this->displayAt = new DateTime();
        $this->hideAt = new DateTime("+5 years");
        $this->participationStartsAt = new DateTime("+ 1 week");
        $this->participationEndsAt = new DateTime("+1 month");
        $this->voteBeginsAt = $this->participationEndsAt;
        $this->voteEndsAt = new DateTime("+6 weeks");
        $this->deliberationAt = new DateTime("+45 days");
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

    public function getState(): ?int
    {
        return $this->state;
    }

    public function setState(int $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function hasOneValidTranslation(): bool
    {
        foreach ($this->challengeTranslations as $trans) {
            if ($trans->getState() === ChallengeTranslation::PUBLISHED) {
                return true;
            }
        }
        return false;
    }


    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setMainImageFile(?File $imageFile = null): void
    {
        $this->mainImageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getMainImageFile(): ?File
    {
        return $this->mainImageFile;
    }

    public function setMainImageName(?string $imageName): void
    {
        $this->mainImageName = $imageName;
    }

    public function getMainImageName(): ?string
    {
        return $this->mainImageName;
    }

    public function getMaxParticipationsPerProfile(): ?int
    {
        return $this->maxParticipationsPerProfile;
    }

    public function setMaxParticipationsPerProfile(int $maxParticipationsPerProfile): self
    {
        $this->maxParticipationsPerProfile = $maxParticipationsPerProfile;

        return $this;
    }
}
