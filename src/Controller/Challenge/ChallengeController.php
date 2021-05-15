<?php

namespace App\Controller\Challenge;

use App\Entity\Challenge\Challenge;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\Challenge\ChallengeRepository;
use App\Repository\Challenge\ChallengeTranslationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ChallengeController extends AbstractController
{
    /**
     * @Route("/challenges", name="challenge_index")
     */
    public function index(Request $request, ChallengeRepository $challengeRepository): Response
    {
        $locale = $request->getLocale();

        $challenges = $challengeRepository->findAllChallengesByLocale($locale);

        return $this->render('challenge/challenge/index.html.twig', [
            'challenges' => $challenges,
        ]);
    }

    /**
     * @Route("/challenge/{id}", name="challenge_show", requirements={"id"="\d+"})
     */
    public function show(Request $request, Challenge $challenge, ChallengeTranslationRepository $challengeTranslationRepository)
    {
        $locale = $request->getLocale();

        $challengeContent = $challengeTranslationRepository->findOneBy(['locale' => $locale]);

        return $this->render('challenge/challenge/show.html.twig', [
            'challengeContent' => $challengeContent,
            'challenge' => $challenge
        ]);
    }
}
