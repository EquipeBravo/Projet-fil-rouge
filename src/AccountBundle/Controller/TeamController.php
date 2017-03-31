<?php

namespace AccountBundle\Controller;

use AccountBundle\Entity\Team;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AccountBundle\Entity\Category;

/**
 * Team controller.
 *
 */
class TeamController extends Controller
{
    /**
     * Lists all team entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $teams = $em->getRepository('AccountBundle:Team')->findAll();

        return $this->render('AccountBundle:team:index.html.twig', array(
            'teams' => $teams,
        ));
    }

    /**
     * Creates a new team entity.
     *
     */
    public function newAction(Request $request)
    {
        $team = new Team();
        $form = $this->createForm('AccountBundle\Form\TeamType', $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($team);
            $em->flush($team);

            return $this->redirectToRoute('team_show', array('id' => $team->getId()));
        }

        return $this->render('AccountBundle:team:new.html.twig', array(
            'team' => $team,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a team entity.
     *
     */
    public function showAction(Team $team)
    {
        $deleteForm = $this->createDeleteForm($team);

        return $this->render('AccountBundle:team:show.html.twig', array(
            'team' => $team,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing team entity.
     *
     */
    public function editAction(Request $request, Team $team)
    {
        $deleteForm = $this->createDeleteForm($team);
        $editForm = $this->createForm('AccountBundle\Form\TeamType', $team);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('team_edit', array('id' => $team->getId()));
        }

        return $this->render('AccountBundle:team:edit.html.twig', array(
            'team' => $team,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a team entity.
     *
     */
    public function deleteAction(Request $request, Team $team)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AccountBundle:Team')->find($team);

        if (!$entity) {
            throw $this->createNotFoundException('ERROR : No such entity');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirectToRoute('team_index');
    }

    /**
     * Creates a form to delete a team entity.
     *
     * @param Team $team The team entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Team $team)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('team_delete', array('id' => $team->getId())))
            ->setMethod('DELETE')
            ->getForm();
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

        return $this->render('AppBundle::teams.html.twig', array(
            'teams' => $teams,
        ));
    }

    /**
     * Finds and displays team's members
     *
     * @param Team $team
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function teamMembersAction(Team $team)
    {
        $em = $this->getDoctrine()->getManager();
        $qb =$em ->createQuiryBuilder();

       /*
       $qb->innerJoin('p.Person', 't', 'WITH', 'p.teams = ?1')
       $qb ->select('p')
            ->from('Person', 'p')
            ->where('p.teams')*/
        $persons = $em->getRepository('AccountBundle:Person')->findBy(['teams' => $team], ['lastName'=>'ASC']);

        return $this->render('AppBundle:team:show.html.twig', array(
            'team' => $team,
            'persons' => $persons,
        ));
    }




}
