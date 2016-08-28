<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Challenge;
use AppBundle\Form\ChallengeType;

/**
 * Challenge controller.
 *
 * @Route("/sgar")
 */
class ChallengeController extends Controller
{
    /**
     * Lists all Challenge entities.
     *
     * @Route("/", name="sgar_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $challenges = $em->getRepository('AppBundle:Challenge')->findAll();

        return $this->render('challenge/index.html.twig', array(
            'challenges' => $challenges,
        ));
    }

    /**
     * Creates a new Challenge entity.
     *
     * @Route("/new", name="sgar_new")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $challenge = new Challenge();
        $form = $this->createForm('AppBundle\Form\Type\ChallengeType', $challenge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($challenge);
            $em->flush();

            return $this->redirectToRoute('sgar_show', array('id' => $challenge->getId()));
        }

        return $this->render('challenge/new.html.twig', array(
            'challenge' => $challenge,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Challenge entity.
     *
     * @Route("/{id}", name="sgar_show")
     * @Method("GET")
     *
     * @param Challenge $challenge
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Challenge $challenge)
    {
        $deleteForm = $this->createDeleteForm($challenge);

        return $this->render('challenge/show.html.twig', array(
            'challenge' => $challenge,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Challenge entity.
     *
     * @Route("/{id}/edit", name="sgar_edit")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @param Challenge $challenge
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Challenge $challenge)
    {
        $deleteForm = $this->createDeleteForm($challenge);
        $editForm = $this->createForm('AppBundle\Form\ChallengeType', $challenge);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($challenge);
            $em->flush();

            return $this->redirectToRoute('sgar_edit', array('id' => $challenge->getId()));
        }

        return $this->render('challenge/edit.html.twig', array(
            'challenge' => $challenge,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Challenge entity.
     *
     * @Route("/{id}", name="sgar_delete")
     * @Method("DELETE")
     *
     * @param Request $request
     * @param Challenge $challenge
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Challenge $challenge)
    {
        $form = $this->createDeleteForm($challenge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($challenge);
            $em->flush();
        }

        return $this->redirectToRoute('sgar_index');
    }

    /**
     * Creates a form to delete a Challenge entity.
     *
     * @param Challenge $challenge The Challenge entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Challenge $challenge)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sgar_delete', array('id' => $challenge->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
