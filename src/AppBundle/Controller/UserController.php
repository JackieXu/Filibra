<?php


namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
     * @Route("/overview")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function overviewPageAction()
    {
        if (!$this->isGranted('ROLE_USER')) {

            $this->addFlash('error', 'You need to be logged in to view this page.');

            return $this->render(':default:index.html.twig')->setStatusCode(403);
        }

        $this->addFlash('info', 'Succesfully logged in');

        return $this->render(':default:index.html.twig');
    }
}
