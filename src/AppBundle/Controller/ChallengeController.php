<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Challenge;
use AppBundle\Form\Type\ChallengeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ChallengeController
 *
 * @package AppBundle\Controller
 */
class ChallengeController extends BaseController
{
    /**
     * Displays list of challenges.
     *
     * @Route("/challenges", name="challenges")
     *
     * @return Response
     */
    public function listPageAction(): Response
    {
        $challengeRepository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Challenge');
        $challenges = $challengeRepository->findAllActiveChallenges();

        return $this->render(':challenge:index.html.twig', [
            'challenges' => $challenges
        ]);
    }

    /**
     * Displays challenge creation page.
     *
     * @Route("/challenges/new", name="new_challenge")
     *
     * TODO: Different action if user isn't an admin. Need proper pages for this.
     * TODO: Handle dates properly for new challenges.
     *
     * @param Request $request
     * @return Response
     */
    public function createPageAction(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to view this page.');

        $challenge = new Challenge();
        $challengeForm = $this->createForm(ChallengeType::class, $challenge);

        $challengeForm->handleRequest($request);

        if ($challengeForm->isSubmitted() && $challengeForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($challenge);
            $entityManager->flush();

            $this->addFlash('info', 'Successfully created new challenge.');

            return $this->redirectToRoute('challenge', [
                'slug' => $challenge->getSlug()
            ]);
        }

        return $this->render('challenge/form.html.twig', [
            'form' => $challengeForm->createView()
        ]);
    }

    /**
     * View single challenge page
     *
     * @Route("/challenge/{slug}", name="challenge", requirements={"slug" = "[a-zA-Z0-9\-\_]+"})
     *
     * @return Response
     */
    public function viewChallengeAction($slug): Response
    {
        $challengeRepository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Challenge');
        $challenge = $challengeRepository->findOneBySlug($slug);

        if (!$challenge){
            return $this->render(':challenge:not_found.html.twig');
        }
        return $this->render(':challenge:challenge.html.twig', [
            'challenge' => $challenge,
        ]);
    }

    /**
     * Join challenge
     *
     * @Route("/challenge/{slug}/join", name="join_challenge", requirements={"slug" = "[a-zA-Z0-9\-\_]+"})
     *
     * @return Response
     */
    public function joinChallengeAction($slug): Response
    {
        $challengeRepository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Challenge');
        $challenge = $challengeRepository->findOneBySlug($slug);
    }
}
