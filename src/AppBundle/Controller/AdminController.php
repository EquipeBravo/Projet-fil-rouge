<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Club;
use AccountBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller{
    public function indexAction()
    {
        return $this->render('AppBundle::admin/index.html.twig');
    }

    //need to be in manager/ClubController
    //Club: [history, value] inherit from Content(title, paragraph, image, link ...)
    public function clubAction()
    {
        $em = $this->getDoctrine()->getManager();

        $clubs = $em->getRepository('AppBundle:Club')->findAll();

        return $this->render('AppBundle:admin/club:index.html.twig', array(
            'clubs' => $clubs,
        ));
    }

    //to modify
    //need to be in manager/ClubController
    public function editClubAction(Request $request, Club $club)
    {
        $deleteForm = $this->createDeleteForm($club);
        $editForm = $this->createForm('AppBundle\Form\ClubType', $club);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('club_edit', array('id' => $club->getId()));
        }

        return $this->render('AppBundle:admin/club:edit.html.twig', array(
            'club' => $club,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    //to verify
    /**
     * Creates a form to delete a club entity.
     *
     * @param Club $club The club entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Club $club)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('club_delete', array('id' => $club->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    /**
     * Finds and displays teams by given category
     *
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function sortByCategoryAction(Request $request, Category $category)
    {
        $em = $this->getDoctrine()->getManager();

        $teams = $em->getRepository('AccountBundle:Team')->findBy(['category' => $category], ['name'=>'ASC']);

        return $this->render('AccountBundle:team:index.html.twig', array(
            'teams' => $teams,
        ));
    }
}