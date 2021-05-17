<?php

namespace App\Controller\Profile;

use App\Entity\Profile;
use App\Form\Profile\ProfileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfileController extends AbstractController
{
    /**
     * @Route("profile/{id}", name="profile_show", requirements={"id"="\d+"})
     */
    public function show(Profile $profile): Response
    {
        return $this->render('profile/profile/index.html.twig', [
            'profile' => $profile,
        ]);
    }

    /**
     * @Route("/profile/edit", name="profile_edit")
     */
    public function edit(Request $request, TranslatorInterface $translatorInterface): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        $user  = $this->getUser();
        $profile = $user->getProfile();
        if (null === $profile) {
            $profile = (new Profile())->setUser($user);
        }
        $form = $this->createForm(ProfileType::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($profile);
            $em->flush();
            $this->addFlash("success", $translatorInterface->trans('app_update_success'));
            if ($redirect = $request->getSession()->get('target_path')) {
                return new RedirectResponse($redirect);
            }
        }

        return $this->render('profile/profile/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
