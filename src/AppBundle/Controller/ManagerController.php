<?php

namespace AppBundle\Controller;

use PlanningBundle\Entity\Place;
use PlanningBundle\Entity\Matchs;
use AppBundle\Entity\Event;
use AppBundle\Entity\Club;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ManagerController extends Controller{
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
}