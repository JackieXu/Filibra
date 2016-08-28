<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * Displays home page.
     *
     * @Route("/")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homePageAction()
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
    public function aboutPageAction()
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
    public function contactPageAction()
    {
        return $this->render(':default:index.html.twig');
    }
}
