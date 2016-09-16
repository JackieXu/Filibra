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
class UserController extends Controller
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

            return $this->render(':default:index.html.twig')->setStatusCode(403);
        }

        return $this->render(':default:index.html.twig');
    }
}
