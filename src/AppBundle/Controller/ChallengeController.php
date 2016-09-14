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
class ChallengeController extends Controller
{
    /**
     * Displays list of challenges.
     *
     * @Route("/challenges")
     *
     * @return Response
     */
    public function listPageAction(): Response
    {
        $challengeRepository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Challenge');
        $challenges = $challengeRepository->findAllActiveChallenges();

        return $this->render('challenge/index.html.twig', [
            'challenges' => $challenges
        ]);
    }
}
