<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class BaseController extends Controller
{

    /**
     * @param string $view
     * @param array $parameters
     * @param Response|null $response
     *
     * @return Response
     */
    public function render($view, array $parameters = array(), Response $response = null): Response
    {
        if (!$this->isGranted('ROLE_USER')) {
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

        $parameters['facebook_login_url'] = $facebookLoginURL;
        $parameters['instagram_login_url'] = $instagramLoginURL;
    }
}