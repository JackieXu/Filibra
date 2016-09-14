<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DefaultController extends Controller
{
    /**
     * Displays home page.
     *
     * @Route("/")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homePageAction(): Response
    {
        $facebookLoginURL = $this->get('facebook.service')->getLoginURL(
            $this->generateUrl(
                'app_authentication_facebookloginhandler',
                [],
                UrlGeneratorInterface::ABSOLUTE_URL
            )
        );

        $instagramLoginURL = $this->get('instagram.service')->getLoginURL(
            $this->generateUrl(
                'app_authentication_instagramloginhandler',
                [],
                UrlGeneratorInterface::ABSOLUTE_URL
            )
        );

        return $this->render(':default:index.html.twig', [
            'facebook_login_url' => $facebookLoginURL,
            'instagram_login_url' => $instagramLoginURL
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
     * @Route("/contact")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contactPageAction(): Response
    {
        return $this->render(':default:index.html.twig');
    }
}
