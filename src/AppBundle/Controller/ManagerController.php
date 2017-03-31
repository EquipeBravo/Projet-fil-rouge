<?php

namespace AppBundle\Controller;

use AccountBundle\Entity\Team;
use PlanningBundle\Entity\Place;
use PlanningBundle\Entity\Matchs;
use AppBundle\Entity\Event;
use AppBundle\Entity\Club;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ManagerController extends Controller
{
    /*
     * Fonction permettant à un Manager de supprimer
     * un évènement
     */
    public function deleteEventAction(Request $request, Event $event)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Event')->find($event);

        if (!$entity) {
            throw $this->createNotFoundException('ERROR : No such entity');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirectToRoute('app_homepage');
    }

    /*
     * Fonction permettant à un Manager de supprimer
     * une information du Club (page A-propos)
     */
    public function deleteClubAction(Request $request, Club $club)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Club')->find($club);

        if (!$entity) {
            throw $this->createNotFoundException('ERROR : No such entity');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirectToRoute('app_homepage');
    }

    /*
     * Fonction permettant à un Manager de supprimer
     * un match
     */
    public function deleteMatchAction(Request $request, Matchs $match)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('PlanningBundle:Matchs')->find($match);

        if (!$entity) {
            throw $this->createNotFoundException('ERROR : No such entity');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirectToRoute('app_homepage');
    }

    /*
     * Fonction permettant à un Manager de supprimer
     * une salle
     */
    public function deletePlaceAction(Request $request, Place $place)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('PlanningBundle:Place')->find($place);

        if (!$entity) {
            throw $this->createNotFoundException('ERROR : No such entity');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirectToRoute('app_homepage');
    }

    /*
     * Fonction permettant à un Manager de modifier
     * une information du club (page A-propos)
     */
    public function editClubAction(Request $request, Club $club)
    {
        $editForm = $this->createForm('AppBundle\Form\ClubType', $club);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_homepage', array('id' => $club->getId()));
        }

        return $this->render('AppBundle:manager:editClub.html.twig', array(
            'club' => $club,
            'edit_form' => $editForm->createView(),
        ));
    }

    /*
     * Fonction permettant à un Manager de modifier
     * un évènement
     */
    public function editEventAction(Request $request, Event $event)
    {
        $editForm = $this->createForm('AppBundle\Form\EventType', $event);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_homepage', array('id' => $event->getId()));
        }

        return $this->render('AppBundle:manager:editEvent.html.twig', array(
            'event' => $event,
            'edit_form' => $editForm->createView(),
        ));
    }

    /*
     * Fonction permettant à un Manager de modifier
     * une équipe
     */
    public function editTeamAction(Request $request, Team $team)
    {
        $editForm = $this->createForm('AccountBundle\Form\TeamType', $team);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_homepage', array('id' => $team->getId()));
        }

        return $this->render('AppBundle:manager:editTeam.html.twig', array(
            'team' => $team,
            'edit_form' => $editForm->createView(),
        ));
    }

    /*
     * Fonction permettant à un Manager de modifier
     * un match
     */
    public function editMatchAction(Request $request, Matchs $matchs)
    {
        $editForm = $this->createForm('PlanningBundle\Form\MatchsType', $matchs);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_homepage', array('id' => $matchs->getId()));
        }

        return $this->render('AppBundle:manager:editMatchs.html.twig', array(
            'matchs' => $matchs,
            'edit_form' => $editForm->createView(),
        ));
    }

    /*
     * Fonction permettant à un Manager de créer
     * une information sur le Club (page A-propos)
     */
    public function newClubAction(Request $request)
    {
        $club = new Club();
        $form = $this->createForm('AppBundle\Form\ClubType', $club);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($club);
            $em->flush($club);

            return $this->redirectToRoute('app_homepage', array('id' => $club->getId()));
        }

        return $this->render('AppBundle:manager:newClub.html.twig', array(
            'club' => $club,
            'form' => $form->createView(),
        ));
    }

    /*
     * Fonction permettant à un Manager de créer
     * un évènement
     */
    public function newEventAction(Request $request)
    {
        $event = new Event();
        $form = $this->createForm('AppBundle\Form\EventType', $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush($event);

            return $this->redirectToRoute('app_homepage', array('id' => $event->getId()));
        }

        return $this->render('AppBundle:manager:newEvent.html.twig', array(
            'event' => $event,
            'form' => $form->createView(),
        ));
    }

    /*
     * Fonction permettant à un Manager de créer
     * une équipe
     */
    public function newTeamAction(Request $request)
    {
        $team = new Team();
        $form = $this->createForm('AccountBundle\Form\TeamType', $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($team);
            $em->flush($team);

            return $this->redirectToRoute('app_homepage', array('id' => $team->getId()));
        }

        return $this->render('AppBundle:manager:newEvent.html.twig', array(
            'team' => $team,
            'form' => $form->createView(),
        ));
    }

    /*
     * Fonction permettant à un Manager de créer
     * un match
     */
    public function newMatchAction(Request $request)
    {
        $matchs = new Matchs();
        $form = $this->createForm('PlanningBundle\Form\MatchsType', $matchs);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($matchs);
            $em->flush($matchs);

            return $this->redirectToRoute('app_homepage', array('id' => $matchs->getId()));
        }

        return $this->render('AppBundle:manager:newMatchs.html.twig', array(
            'matchs' => $matchs,
            'form' => $form->createView(),
        ));
    }
}