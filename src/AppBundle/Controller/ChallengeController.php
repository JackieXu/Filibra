<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
