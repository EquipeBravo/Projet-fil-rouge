<?php

namespace PlanningBundle\Controller;

use PlanningBundle\Entity\Place;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Place controller.
 *
 */
class PlaceController extends Controller
{
    /**
     * Lists all place entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $places = $em->getRepository('PlanningBundle:Place')->findAll();

        return $this->render('PlanningBundle:place:index.html.twig', array(
            'places' => $places,
        ));
    }

    /**
     * Creates a new place entity.
     *
     */
    public function newAction(Request $request)
    {
        $place = new Place();
        $form = $this->createForm('PlanningBundle\Form\PlaceType', $place);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($place);
            $em->flush($place);

            return $this->redirectToRoute('place_show', array('id' => $place->getId()));
        }

        return $this->render('PlanningBundle:place:new.html.twig', array(
            'place' => $place,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a place entity.
     *
     */
    public function showAction(Place $place)
    {
        $deleteForm = $this->createDeleteForm($place);

        return $this->render('PlanningBundle:place:show.html.twig', array(
            'place' => $place,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing place entity.
     *
     */
    public function editAction(Request $request, Place $place)
    {
        $deleteForm = $this->createDeleteForm($place);
        $editForm = $this->createForm('PlanningBundle\Form\PlaceType', $place);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('place_edit', array('id' => $place->getId()));
        }

        return $this->render('PlanningBundle:place:edit.html.twig', array(
            'place' => $place,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a place entity.
     *
     */
    public function deleteAction(Request $request, Place $place)
    {
        $form = $this->createDeleteForm($place);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($place);
            $em->flush($place);
        }

        return $this->redirectToRoute('place_index');
    }

    /**
     * Creates a form to delete a place entity.
     *
     * @param Place $place The place entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Place $place)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('place_delete', array('id' => $place->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
