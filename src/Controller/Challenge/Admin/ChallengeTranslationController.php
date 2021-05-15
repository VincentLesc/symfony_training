<?php

namespace App\Controller\Challenge\Admin;

use App\Entity\Challenge\Challenge;
use App\Entity\Challenge\ChallengeTranslation;
use App\Form\Challenge\ChallengeTranslationType;
use App\Repository\Challenge\ChallengeTranslationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/challenge/admin/challenge/translation")
 */
class ChallengeTranslationController extends AbstractController
{
    /**
     * @Route("/", name="challenge_admin_challenge_translation_index", methods={"GET"})
     */
    public function index(ChallengeTranslationRepository $challengeTranslationRepository): Response
    {
        return $this->render('challenge/admin/challenge_translation/index.html.twig', [
            'challenge_translations' => $challengeTranslationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="challenge_admin_challenge_translation_new", methods={"GET","POST"})
     */
    public function new(Request $request, Challenge $challenge): Response
    {
        $challengeTranslation = new ChallengeTranslation();
        $challengeTranslation->setChallenge($challenge);
        $form = $this->createForm(ChallengeTranslationType::class, $challengeTranslation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($challengeTranslation);
            $entityManager->flush();

            return $this->redirectToRoute('challenge_admin_challenge_translation_index');
        }

        return $this->render('challenge/admin/challenge_translation/new.html.twig', [
            'challenge_translation' => $challengeTranslation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="challenge_admin_challenge_translation_show", methods={"GET"})
     */
    public function show(ChallengeTranslation $challengeTranslation): Response
    {
        return $this->render('challenge/admin/challenge_translation/show.html.twig', [
            'challenge_translation' => $challengeTranslation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="challenge_admin_challenge_translation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ChallengeTranslation $challengeTranslation): Response
    {
        $form = $this->createForm(ChallengeTranslationType::class, $challengeTranslation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('challenge_admin_challenge_translation_index');
        }

        return $this->render('challenge/admin/challenge_translation/edit.html.twig', [
            'challenge_translation' => $challengeTranslation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="challenge_admin_challenge_translation_delete", methods={"POST"})
     */
    public function delete(Request $request, ChallengeTranslation $challengeTranslation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$challengeTranslation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($challengeTranslation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('challenge_admin_challenge_translation_index');
    }
}
