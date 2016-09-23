<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DefaultController extends BaseController
{
    /**
     * Displays home page.
     *
     * @Route("/", name="index")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homePageAction(): Response
    {
        $challengeRepository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Challenge');
        #$featuredChallenges = $challengeRepository->findFeaturedChallenges();
        $newestChallenges = $challengeRepository->findNewestChallenges();

        return $this->render(':default:index.html.twig', [
            #'featured_challenges' => $featuredChallenges
            'newest_challenges' => $newestChallenges
        ]);
    }

    /**
     * Displays about page.
     *
     * @Route("/about")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function aboutPageAction(): Response
    {
        return $this->render(':default:index.html.twig');
    }

    /**
     * Displays contact page.
     *
     * @Route("/contact", name="contact")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contactPageAction(): Response
    {
        return $this->render(':default:index.html.twig');
    }
}
