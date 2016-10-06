<?php


namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
     * @Route("/overview", name="overview_page")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function overviewPageAction(): Response
    {
        if (!$this->isGranted('ROLE_USER')) {
            $this->addFlash('error', 'You need to be logged in to view this page.');

            return $this->redirectToRoute('index_page');
        }

        return $this->render(':user:overview.html.twig');
    }

    /**
     * Displays user's profile page.
     *
     * @Route("/profile", name="profile_page")
     *
     * @return Response
     */
    public function profilePageAction(): Response
    {
        if (!$this->isGranted('ROLE_USER')) {
            $this->addFlash('error', 'You need to be logged in to view this page.');

            return $this->redirectToRoute('index_page');
        }

        return $this->render(':user:profile.html.twig', []);
    }
}
