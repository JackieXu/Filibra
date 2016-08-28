<?php


namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * Class AuthenticationController
 *
 * @package AppBundle\Controller
 */
class AuthenticationController extends Controller
{
    /**
     * Handles Instagram login redirect.
     *
     * @Route("/login")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function loginHandler(Request $request)
    {
        if ($request->query->has('error')) {
            return $this->redirectToRoute('app_default_homepage');
        }

        $instagramData = $this->get('instagram')->login(
            $request->query->get('code'),
            $this->generateUrl('app_authentication_loginhandler', [], UrlGeneratorInterface::ABSOLUTE_URL)
        );

        if ($instagramData) {
            $user = $this->get('user.service')->loginWithInstragram($instagramData);
            $token = new UsernamePasswordToken($user, $user->getInstagramAccessToken(), 'main', ['ROLE_USER']);
            $event = new InteractiveLoginEvent($request, $token);

            $this->get('security.token_storage')->setToken($token);
            $this->get('event_dispatcher')->dispatch('security.interactive_login', $event);

            return $this->redirectToRoute('app_user_overviewpage');
        }

        $this->addFlash('error', 'Something went wrong via Instagram. Try again later.');

        return $this->redirectToRoute('app_default_homepage');
    }

    /**
     * Handles log out action.
     *
     * @Route("/logout")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function logoutHandler(Request $request)
    {
        if ($this->getUser()) {
            $this->get('security.token_storage')->setToken(null);
            $request->getSession()->invalidate();

            $this->addFlash('info', 'Succesfully logged out');
        } else {
            $this->addFlash('error', 'Not logged in; unable to log out.');
        }

        return $this->redirectToRoute('app_default_homepage');
    }
}
