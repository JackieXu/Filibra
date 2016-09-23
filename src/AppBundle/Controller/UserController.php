<?php


namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UserController
 *
 * @package AppBundle\Controller
 */
class UserController extends BaseController
{
    /**
     * Displays user's overview page.
     *
     * @Route("/overview", name="overview")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function overviewPageAction(): Response
    {
        if (!$this->isGranted('ROLE_USER')) {
            $this->addFlash('error', 'You need to be logged in to view this page.');

            return $this->redirectToRoute('index');
        }

        return $this->render(':user:overview.html.twig');
    }

    /**
     * Displays user's profile page.
     *
     * @Route("/profile")
     *
     * @return Response
     */
    public function profilePageAction(): Response
    {
        if (!$this->isGranted('ROLE_USER')) {

            $this->addFlash('error', 'You need to be logged in to view this page.');

            return $this->render(':default:index.html.twig')->setStatusCode(403);
        }

        return $this->render(':user:profile.html.twig', []);
    }
}
