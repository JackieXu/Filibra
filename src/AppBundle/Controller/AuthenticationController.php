<?php


namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * Class AuthenticationController
 *
 * @package AppBundle\Controller
 */
class AuthenticationController extends BaseController
{
    /**
     * Handles Facebook login redirect.
     *
     * @Route("/login/facebook")
     *
     * @param Request $request
     * @return Response
     */
    public function facebookLoginHandler(Request $request): Response
    {
        $facebookService = $this->get('facebook.service');
        $accessToken = $facebookService->getAccessToken();
        $graphUser = $facebookService->getUserByAccessToken($accessToken);

        if ($graphUser) {
            $user = $this->get('user.service')->loginWithFacebook($accessToken, $graphUser);

            $token = new UsernamePasswordToken($user, $user->getFacebookAccessToken(), 'main', ['ROLE_USER']);
            $event = new InteractiveLoginEvent($request, $token);

            $this->get('security.token_storage')->setToken($token);
            $this->get('event_dispatcher')->dispatch('security.interactive_login', $event);

            $this->addFlash('info', 'Succesfully logged in');

            return $this->redirectToRoute('overview');
        }

        $this->addFlash('error', 'Something went wrong via Facebook. Try again later.');

        return $this->redirectToRoute('index');
    }

    /**
     * Handles Instagram login redirect.
     *
     * @Route("/login/instagram")
     *
     * @param Request $request
     * @return Response
     */
    public function instagramLoginHandler(Request $request): Response
    {
        if ($request->query->has('error')) {
            return $this->redirectToRoute('index');
        }

        $instagramData = $this->get('instagram.service')->login(
            $request->query->get('code'),
            $this->generateUrl('app_authentication_instagramloginhandler', [], UrlGeneratorInterface::ABSOLUTE_URL)
        );

        if ($instagramData) {
            $user = $this->get('user.service')->loginWithInstagram($instagramData);

            $token = new UsernamePasswordToken($user, $user->getInstagramAccessToken(), 'main', ['ROLE_USER']);
            $event = new InteractiveLoginEvent($request, $token);

            $this->get('security.token_storage')->setToken($token);
            $this->get('event_dispatcher')->dispatch('security.interactive_login', $event);

            $this->addFlash('info', 'Succesfully logged in');

            return $this->redirectToRoute('overview');
        }

        $this->addFlash('error', 'Something went wrong via Instagram. Try again later.');

        return $this->redirectToRoute('index');
    }

    /**
     * Handles log out action.
     *
     * @Route("/logout")
     *
     * @param Request $request
     * @return Response
     */
    public function logoutHandler(Request $request): Response
    {
        if ($this->getUser()) {
            $this->get('security.token_storage')->setToken(null);
            $request->getSession()->invalidate();

            $this->addFlash('info', 'Succesfully logged out');
        } else {
            $this->addFlash('error', 'Not logged in; unable to log out.');
        }

        return $this->redirectToRoute('index');
    }
}
