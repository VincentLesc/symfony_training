<?php

namespace App\Controller\Challenge;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\Challenge\ChallengeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ChallengeController extends AbstractController
{
    /**
     * @Route("/challenges", name="challenge_index")
     */
    public function index(Request $request, ChallengeRepository $challengeRepository): Response
    {
        $locale = $request->getLocale();
    
        return $this->render('challenge/challenge/index.html.twig', [
            'controller_name' => 'ChallengeController',
        ]);
    }
}
