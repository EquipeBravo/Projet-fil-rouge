<?php

namespace PlanningBundle\Controller;

use PlanningBundle\Entity\Matchs;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Match controller.
 *
 */
class MatchsController extends Controller
{
    /**
     * Lists all match entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $matchs = $em->getRepository('PlanningBundle:Matchs')->findAll();

        return $this->render('matchs/index.html.twig', array(
            'matchs' => $matchs,
        ));
    }

    /**
     * Creates a new match entity.
     *
     */
    public function newAction(Request $request)
    {
        $match = new Match();
        $form = $this->createForm('PlanningBundle\Form\MatchsType', $match);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($match);
            $em->flush($match);

            return $this->redirectToRoute('matchs_show', array('id' => $match->getId()));
        }

        return $this->render('matchs/new.html.twig', array(
            'match' => $match,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a match entity.
     *
     */
    public function showAction(Matchs $match)
    {
        $deleteForm = $this->createDeleteForm($match);

        return $this->render('matchs/show.html.twig', array(
            'match' => $match,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing match entity.
     *
     */
    public function editAction(Request $request, Matchs $match)
    {
        $deleteForm = $this->createDeleteForm($match);
        $editForm = $this->createForm('PlanningBundle\Form\MatchsType', $match);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('matchs_edit', array('id' => $match->getId()));
        }

        return $this->render('matchs/edit.html.twig', array(
            'match' => $match,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a match entity.
     *
     */
    public function deleteAction(Request $request, Matchs $match)
    {
        $form = $this->createDeleteForm($match);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($match);
            $em->flush($match);
        }

        return $this->redirectToRoute('matchs_index');
    }

    /**
     * Creates a form to delete a match entity.
     *
     * @param Matchs $match The match entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Matchs $match)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('matchs_delete', array('id' => $match->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
