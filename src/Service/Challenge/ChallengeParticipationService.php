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

    public function canProfileParticipate(Challenge $challenge, Profile $profile)
    {
        $maxParticipations = $challenge->getMaxParticipationsPerProfile();
        $participations = $this->challengeParticipationRepository->findBy(['challenge' => $challenge, 'profile' => $profile]);
        if (count($participations) >= $maxParticipations) {
            return [
                'response' => false,
                'reason' => 'max_participation'
            ];
        }

        return [
            'response' => true,
        ];
    }
}
