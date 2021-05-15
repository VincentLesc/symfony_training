<?php

namespace App\Controller\Challenge\Admin;

use App\Entity\Challenge\Challenge;
use App\Form\Challenge\ChallengeType;
use App\Repository\Challenge\ChallengeRepository;
use App\Service\Challenge\ChallengeStateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/challenge/admin/challenge")
 */
class ChallengeController extends AbstractController
{
    /**
     * @Route("/", name="challenge_admin_challenge_index", methods={"GET"})
     */
    public function index(ChallengeRepository $challengeRepository): Response
    {
        return $this->render('challenge/admin/challenge/index.html.twig', [
            'challenges' => $challengeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="challenge_admin_challenge_new", methods={"GET","POST"})
     */
    public function new(Request $request, ChallengeStateService $challengeStateService): Response
    {
        $challenge = new Challenge();
        $form = $this->createForm(ChallengeType::class, $challenge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $challengeStateService->updateState($challenge);
            $entityManager->persist($challenge);
            $entityManager->flush();

            return $this->redirectToRoute('challenge_admin_challenge_index');
        }

        return $this->render('challenge/admin/challenge/new.html.twig', [
            'challenge' => $challenge,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="challenge_admin_challenge_show", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function show(Challenge $challenge): Response
    {
        return $this->render('challenge/admin/challenge/show.html.twig', [
            'challenge' => $challenge,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="challenge_admin_challenge_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Challenge $challenge, ChallengeStateService $challengeStateService): Response
    {
        $form = $this->createForm(ChallengeType::class, $challenge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $challengeStateService->updateState($challenge);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('challenge_admin_challenge_index');
        }

        return $this->render('challenge/admin/challenge/edit.html.twig', [
            'challenge' => $challenge,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="challenge_admin_challenge_delete", methods={"POST"})
     */
    public function delete(Request $request, Challenge $challenge): Response
    {
        if ($this->isCsrfTokenValid('delete'.$challenge->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($challenge);
            $entityManager->flush();
        }

        return $this->redirectToRoute('challenge_admin_challenge_index');
    }
}
