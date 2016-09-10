<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

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
        return $this->render(':default:index.html.twig');
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
