<?php

namespace App\Service\Challenge;

use DateTime;
use App\Entity\Challenge\Challenge;
use App\Repository\Challenge\ChallengeRepository;

class ChallengeStateService
{
    private ChallengeRepository $challengeRepository;

    public function __construct(ChallengeRepository $challengeRepository)
    {
        $this->challengeRepository = $challengeRepository;
    }

    public function updateState(Challenge $challenge)
    {
        $now = new DateTime('now');
        $state = Challenge::DRAFT;
        
        if (! $challenge->hasOneValidTranslation()) {
            $state = Challenge::DRAFT;
        } elseif ($challenge->getHideAt() < $now) {
            $state = Challenge::CLOSED;
        } elseif ($challenge->getDeliberationAt() < $now) {
            $state = Challenge::DELIBERATED;
        } elseif ($challenge->getVoteEndsAt() < $now) {
            $state = Challenge::WAIT_DELIBERATION;
        } elseif ($challenge->getVoteBeginsAt() < $now) {
            $state = Challenge::VOTE;
        } elseif ($challenge->getParticipationStartsAt() < $now) {
            $state = Challenge::PARTICIPATION;
        } elseif ($challenge->getDisplayAt() < $now) {
            $state = Challenge::PUBLISHED;
        }

        $challenge->setState($state);
    }
}
