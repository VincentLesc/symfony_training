<?php

namespace App\Service\Challenge;

use DateTime;
use App\Entity\Profile;
use App\Entity\Challenge\Challenge;
use App\Repository\Challenge\ChallengeParticipationRepository;
use App\Repository\Challenge\ChallengeRepository;

class ChallengeParticipationService
{
    private ChallengeRepository $challengeRepository;

    private ChallengeParticipationRepository $challengeParticipationRepository;

    public function __construct(ChallengeRepository $challengeRepository, ChallengeParticipationRepository $challengeParticipationRepository)
    {
        $this->challengeRepository = $challengeRepository;
        $this->challengeParticipationRepository = $challengeParticipationRepository;
    }

    public function canProfileParticipate(Challenge $challenge, Profile $profile, $participations = null)
    {
        $maxParticipations = $challenge->getMaxParticipationsPerProfile();
        if (null === $participations) {
            $participations = $this->challengeParticipationRepository->findBy(['challenge' => $challenge, 'profile' => $profile]);
        }
        $nbparticipations = count($participations);
        if ($nbparticipations >= $maxParticipations) {
            return [
                'response' => false,
                'createdParticipations' => $nbparticipations,
                'remainingParticipations' => $maxParticipations - $nbparticipations
            ];
        }

        return [
            'response' => true,
            'createdParticipations' => $nbparticipations,
            'remainingParticipations' => $maxParticipations - $nbparticipations
        ];
    }
}
