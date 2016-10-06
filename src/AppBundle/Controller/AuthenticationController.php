<?php


namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
     * @Route("/login/facebook", name="facebook_login_action")
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
            if ($this->isGranted('ROLE_USER')) {
                $this->get('user.service')->linkToFacebook($this->getUser(), $accessToken, $graphUser);

                $this->addFlash('info', 'Succesfully connected Facebook account!');

                return $this->redirectToRoute('profile_page');
            }

            $user = $this->get('user.service')->loginWithFacebook($accessToken, $graphUser);

            $token = new UsernamePasswordToken($user, $user->getFacebookAccessToken(), 'main', $user->getRoles());
            $event = new InteractiveLoginEvent($request, $token);

            $this->get('security.token_storage')->setToken($token);
            $this->get('event_dispatcher')->dispatch('security.interactive_login', $event);

            $this->addFlash('info', 'Succesfully logged in');

            return $this->redirectToRoute('overview_page');
        }

        $this->addFlash('error', 'Something went wrong via Facebook. Try again later.');

        return $this->redirectToRoute('index_page');
    }

    /**
     * Handles Instagram login redirect.
     *
     * @Route("/login/instagram", name="instagram_login_action")
     *
     * @param Request $request
     * @return Response
     */
    public function instagramLoginHandler(Request $request): Response
    {
        if ($request->query->has('error')) {
            return $this->redirectToRoute('index_page');
        }

        $instagramData = $this->get('instagram.service')->login(
            $request->query->get('code'),
            $this->generateUrl('instagram_login_action', [], UrlGeneratorInterface::ABSOLUTE_URL)
        );

        if ($instagramData) {
            if ($this->isGranted('ROLE_USER')) {
                $this->get('user.service')->linkToInstagram($this->getUser(), $instagramData);

                $this->addFlash('info', 'Succesfully connected Instagram account!');

                return $this->redirectToRoute('profile_page');
            }

            $user = $this->get('user.service')->loginWithInstagram($instagramData);

            $token = new UsernamePasswordToken($user, $user->getInstagramAccessToken(), 'main', $user->getRoles());
            $event = new InteractiveLoginEvent($request, $token);

            $this->get('security.token_storage')->setToken($token);
            $this->get('event_dispatcher')->dispatch('security.interactive_login', $event);

            $this->addFlash('info', 'Succesfully logged in');

            return $this->redirectToRoute('overview_page');
        }

        $this->addFlash('error', 'Something went wrong via Instagram. Try again later.');

        return $this->redirectToRoute('index_page');
    }

    /**
     * Handles log out action.
     *
     * @Route("/logout", name="logout_action")
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

        return $this->redirectToRoute('index_page');
    }
}
