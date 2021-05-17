<?php

namespace App\Controller\Challenge;

use App\Entity\Challenge\Challenge;
use App\Entity\Challenge\ChallengeParticipation;
use App\Form\Challenge\ChallengeParticipationType;
use App\Repository\Challenge\ChallengeParticipationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\Challenge\ChallengeRepository;
use App\Repository\Challenge\ChallengeTranslationRepository;
use App\Service\Challenge\ChallengeParticipationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\Translation\TranslatorInterface;

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
    public function show(
        Request $request,
        Challenge $challenge,
        ChallengeTranslationRepository $challengeTranslationRepository,
        ChallengeParticipationRepository $challengeParticipationRepository,
        ChallengeParticipationService $challengeParticipationService,
        TranslatorInterface $translatorInterface
    ) {
        $locale = $request->getLocale();

        $challengeContent = $challengeTranslationRepository->findOneBy(['locale' => $locale, 'challenge' => $challenge]);
        $userParticipations = [];

        if ($this->getUser()) {
            $userParticipations = $challengeParticipationRepository->findBy(
                [
                'challenge' => $challenge,
                'profile' => $this->getUser()->getProfile(),
                ]
            );

            $profile = $this->getUser()->getProfile();

            if (null === $profile || null === $profile->getBirthdate() || null === $profile->getPseudo()) {
                $this->addFlash('error', $translatorInterface->trans('challenge.participation.complete_profile'));
                return $this->redirectToRoute('profile_edit');
            }

            $participationChecker = $challengeParticipationService->canProfileParticipate($challenge, $profile, $userParticipations);

            if ($challenge->getState() === Challenge::PARTICIPATION && true === $participationChecker['response']) {
                $participation = new ChallengeParticipation();
                $form = $this->createForm(ChallengeParticipationType::class, $participation);
                $form->handleRequest($request);
                
                if ($form->isSubmitted() && $form->isValid()) {
                    $participation->setProfile($this->getUser()->getProfile());
                    $participation->setChallenge($challenge);
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($participation);
                    $entityManager->flush();
                    $participation = new ChallengeParticipation();
                    $form = $this->createForm(ChallengeParticipationType::class, $participation);
    
                    return $this->redirectToRoute('challenge_participation_success', ['id' => $challenge->getId()]);
                }
    
                return $this->render('challenge/challenge/show.html.twig', [
                    'challengeContent' => $challengeContent,
                    'challenge' => $challenge,
                    'form' => $form->createView()
                ]);
            }
        }

        return $this->render('challenge/challenge/show.html.twig', [
            'challengeContent' => $challengeContent,
            'challenge' => $challenge
        ]);
    }

    /**
     * @Route("/challenge/{id}/participation-success", name="challenge_participation_success", requirements={"id"="\d+"})
     */
    public function challengeParticipationSuccess(
        Request $request,
        Challenge $challenge,
        ChallengeTranslationRepository $challengeTranslationRepository,
        ChallengeParticipationRepository $challengeParticipationRepository,
        ChallengeParticipationService $challengeParticipationService
    ) {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');
        if (! $this->getUser()) {
            return $this->redirectToRoute('challenge_show', ['id' => $challenge->getId()]);
        }
        $locale = $request->getLocale();
        $challengeContent = $challengeTranslationRepository->findOneBy(['locale' => $locale, 'challenge' => $challenge]);
        $userParticipations = $challengeParticipationRepository->findBy(
            [
                'challenge' => $challenge,
                'profile' => $this->getUser()->getProfile()
            ],
            [
                'createdAt' => 'DESC'
            ]
        );
        if (count($userParticipations) === 0) {
            return $this->redirectToRoute('challenge_show', ['id' => $challenge->getId()]);
        }

        $participationsChecker = $challengeParticipationService->canProfileParticipate($challenge, $this->getUser()->getProfile(), $userParticipations);


        return $this->render('challenge/challenge/participation_success.html.twig', [
            'challengeContent' => $challengeContent,
            'challenge' => $challenge,
            'userParticipations' => $userParticipations,
            'remainingParticipations' => $participationsChecker['remainingParticipations'],
            'createdParticipations' => $participationsChecker['createdParticipations']
        ]);
    }
}
