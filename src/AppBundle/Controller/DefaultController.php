<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends BaseController
{
    /**
     * Displays home page.
     *
     * @Route("/", name="index_page")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homePageAction(): Response
    {
        $challengeRepository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Challenge');
        $newestChallenges = $challengeRepository->findNewestChallenges();

        return $this->render(':default:index.html.twig', [
            'newest_challenges' => $newestChallenges
        ]);
    }

    /**
     * Displays about page.
     *
     * @Route("/about", name="about_page")
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
     * @Route("/contact", name="contact_page")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contactPageAction(): Response
    {
        return $this->render(':default:index.html.twig');
    }

    /**
     * Displays terms of service page.
     *
     * @Route("/terms-of-service", name="terms_of_service_page")
     *
     * @return Response
     */
    public function termsPageAction(): Response
    {
        return $this->render(':default:terms_of_service.html.twig');
    }

    /**
     * Displays privacy policy page.
     *
     * @Route("/privacy-policy", name="privacy_policy_page")
     *
     * @return Response
     */
    public function policyPageAction(): Response
    {
        return $this->render(':default:privacy_policy.html.twig');
    }
}
