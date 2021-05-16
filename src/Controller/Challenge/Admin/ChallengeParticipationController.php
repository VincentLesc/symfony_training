<?php

namespace App\Controller\Challenge\Admin;

use App\Controller\Admin\AdminController;
use App\Entity\Challenge\ChallengeParticipation;
use App\Form\Challenge\ChallengeParticipationType;
use App\Repository\Challenge\ChallengeParticipationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/challenge/admin/challenge/participation")
 */
class ChallengeParticipationController extends AdminController
{
    /**
     * @Route("/", name="challenge_admin_challenge_participation_index", methods={"GET"})
     */
    public function index(ChallengeParticipationRepository $challengeParticipationRepository): Response
    {
        $this->controlAccess();
        return $this->render('challenge/admin/challenge_participation/index.html.twig', [
            'challenge_participations' => $challengeParticipationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="challenge_admin_challenge_participation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $this->controlAccess();
        $challengeParticipation = new ChallengeParticipation();
        $form = $this->createForm(ChallengeParticipationType::class, $challengeParticipation, ['origin'=> 'admin']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($challengeParticipation);
            $entityManager->flush();

            return $this->redirectToRoute('challenge_admin_challenge_participation_index');
        }

        return $this->render('challenge/admin/challenge_participation/new.html.twig', [
            'challenge_participation' => $challengeParticipation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="challenge_admin_challenge_participation_show", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function show(ChallengeParticipation $challengeParticipation): Response
    {
        $this->controlAccess();
        return $this->render('challenge/admin/challenge_participation/show.html.twig', [
            'challenge_participation' => $challengeParticipation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="challenge_admin_challenge_participation_edit", methods={"GET","POST"}, requirements={"id"="\d+"})
     */
    public function edit(Request $request, ChallengeParticipation $challengeParticipation): Response
    {
        $this->controlAccess();
        $form = $this->createForm(ChallengeParticipationType::class, $challengeParticipation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('challenge_admin_challenge_participation_index');
        }

        return $this->render('challenge/admin/challenge_participation/edit.html.twig', [
            'challenge_participation' => $challengeParticipation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="challenge_admin_challenge_participation_delete", methods={"POST"}, requirements={"id"="\d+"})
     */
    public function delete(Request $request, ChallengeParticipation $challengeParticipation): Response
    {
        $this->controlAccess();
        if ($this->isCsrfTokenValid('delete'.$challengeParticipation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($challengeParticipation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('challenge_admin_challenge_participation_index');
    }
}
