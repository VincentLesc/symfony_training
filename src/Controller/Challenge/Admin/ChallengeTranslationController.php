<?php

namespace App\Controller\Challenge\Admin;

use App\Entity\Challenge\Challenge;
use App\Controller\Admin\AdminController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Challenge\ChallengeTranslation;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Challenge\ChallengeTranslationType;
use App\Repository\Challenge\ChallengeTranslationRepository;

/**
 * @Route("/admin/challenge_translation")
 */
class ChallengeTranslationController extends AdminController
{
    /**
     * @Route("/", name="challenge_admin_challenge_translation_index", methods={"GET"})
     */
    public function index(ChallengeTranslationRepository $challengeTranslationRepository): Response
    {
        $this->controlAccess();
        return $this->render('challenge/admin/challenge_translation/index.html.twig', [
            'challenge_translations' => $challengeTranslationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="challenge_admin_challenge_translation_new", methods={"GET","POST"})
     */
    public function new(Request $request, Challenge $challenge): Response
    {
        $this->controlAccess();
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
        $this->controlAccess();
        return $this->render('challenge/admin/challenge_translation/show.html.twig', [
            'challenge_translation' => $challengeTranslation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="challenge_admin_challenge_translation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ChallengeTranslation $challengeTranslation): Response
    {
        $this->controlAccess();
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
        $this->controlAccess();
        if ($this->isCsrfTokenValid('delete'.$challengeTranslation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($challengeTranslation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('challenge_admin_challenge_translation_index');
    }
}
