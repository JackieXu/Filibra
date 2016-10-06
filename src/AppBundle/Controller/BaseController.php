<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class BaseController extends Controller
{

    /**
     * Renders view.
     *
     * TODO: Clean up the authentication check for adding login URLs.
     * TODO: URLs should only be added if user isn't logged in or on the profile page to connect other media.
     *
     * @param string $view
     * @param array $parameters
     * @param Response|null $response
     *
     * @return Response
     */
    public function render($view, array $parameters = array(), Response $response = null): Response
    {
        if (!$this->isGranted('ROLE_USER') || $view == ':user:profile.html.twig') {
            $this->addLoginURLS($parameters);
        }

        return parent::render($view, $parameters, $response);
    }

    /**
     * Adds Facebook and Instagram login urls to parameters for rendering
     *
     * @param $parameters
     */
    private function addLoginURLS(&$parameters)
    {
        $facebookLoginURL = $this->get('facebook.service')->getLoginURL(
            $this->generateUrl(
                'facebook_login_action',
                [],
                UrlGeneratorInterface::ABSOLUTE_URL
            )
        );

        $instagramLoginURL = $this->get('instagram.service')->getLoginURL(
            $this->generateUrl(
                'instagram_login_action',
                [],
                UrlGeneratorInterface::ABSOLUTE_URL
            )
        );

        $parameters['facebook_login_url'] = $facebookLoginURL;
        $parameters['instagram_login_url'] = $instagramLoginURL;
    }

    /**
     * Redirects user to index page and adds error message.
     *
     * @return Response
     */
    protected function notLoggedInRedirect(): Response
    {
        $this->addFlash('error', 'You need to be logged in to view this page.');

        return $this->redirectToRoute('index_page');
    }
}
