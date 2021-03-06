<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Challenge;
use AppBundle\Entity\ChallengeUser;
use AppBundle\Form\Type\ChallengeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ChallengeController
 *
 * @package AppBundle\Controller
 */
class ChallengeController extends BaseController
{
    /**
     * Displays list of challenges.
     *
     * @Route("/challenges", name="challenge_list_page")
     * @Method("GET")
     *
     * @return Response
     */
    public function listPageAction(): Response
    {
        $challengeRepository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Challenge');
        $challenges = $challengeRepository->findAllActiveChallenges();

        return $this->render(':challenge:index.html.twig', [
            'challenges' => $challenges
        ]);
    }

    /**
     * Displays challenge creation page.
     *
     * @Route("/challenges/new", name="new_challenge_page")
     * @Method("GET")
     *
     * @param Request $request
     * @return Response
     */
    public function createPageAction(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to view this page.');

        $challengeForm = $this->createForm(ChallengeType::class, new Challenge());

        $challengeForm->handleRequest($request);

        return $this->render('challenge/form.html.twig', [
            'form' => $challengeForm->createView()
        ]);
    }

    /**
     * Creates new challenge.
     *
     * @Route("/challenges/new", name="new_challenge_action")
     * @Method("POST")
     *
     * @param Request $request
     * @return Response
     */
    public function createAction(Request $request): Response
    {
        $challenge = new Challenge();
        $challengeForm = $this->createForm(ChallengeType::class, $challenge);

        $challengeForm->handleRequest($request);

        if ($challengeForm->isSubmitted() && $challengeForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($challenge);
            $entityManager->flush();

            $this->addFlash('info', 'Successfully created new challenge.');

            return $this->redirectToRoute('challenge_page', [
                'slug' => $challenge->getSlug()
            ]);
        }

        return $this->redirectToRoute('new_challenge_page');
    }

    /**
     * View single challenge page
     *
     * @Route("/challenge/{slug}", name="challenge_page", requirements={"slug" = "[a-zA-Z0-9\-\_]+"})
     * @Method("GET")
     *
     * @param string $slug
     * @return Response
     */
    public function viewChallengeAction(string $slug): Response
    {
        $challengeRepository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Challenge');
        $challenge = $challengeRepository->findOneBySlug($slug);

        if (!$challenge) {
            throw $this->createNotFoundException();
        }

        return $this->render(':challenge:challenge.html.twig', [
            'challenge' => $challenge,
        ]);
    }

    /**
     * Join challenge
     *
     * @Route("/challenge/{slug}/join", name="join_challenge_action", requirements={"slug" = "[a-zA-Z0-9\-\_]+"})
     * @Method("POST")
     *
     * @param string $slug
     * @return Response
     */
    public function joinChallengeAction(string $slug): Response
    {
        $challengeRepository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Challenge');
        $challenge = $challengeRepository->findOneBySlug($slug);

        if (!$challenge) {
            throw $this->createNotFoundException();
        }

        if (!$this->isGranted('ROLE_USER')) {
            return $this->notLoggedInRedirect();
        }

        if ($this->get('challenge.service')->isUserInChallenge($this->getUser(), $challenge)) {
            $this->addFlash('error', 'Already taking part in this challenge!');

            return $this->redirectToRoute('challenge_page', [
                'slug' => $challenge->getSlug()
            ]);
        }

        $entityManager = $this->getDoctrine()->getManager();

        $challengeUser = new ChallengeUser();
        $challengeUser->setChallenge($challenge);
        $challengeUser->setUser($this->getUser());

        $entityManager->persist($challengeUser);
        $entityManager->flush();

        $this->addFlash('info', $this->get('translator')->trans('challenge.flashes.joined'));

        return $this->redirectToRoute('challenge_page', ['slug' => $challenge->getSlug()]);
    }
}
