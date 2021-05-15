<?php

namespace App\Controller\Challenge;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChallengeController extends AbstractController
{
    /**
     * @Route("/challenges", name="challenge_index")
     */
    public function index(): Response
    {
        return $this->render('challenge/challenge/index.html.twig', [
            'controller_name' => 'ChallengeController',
        ]);
    }
}
