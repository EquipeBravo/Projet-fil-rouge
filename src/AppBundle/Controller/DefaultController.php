<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AccountBundle\Entity\Person;
use AccountBundle\Entity\Team;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository('AppBundle:Event')->findAll();
        return $this->render('AppBundle::index.html.twig', [
            'events' => $events
        ]);
    }

    public function aproposAction()
    {
        $em = $this->getDoctrine()->getManager();

        $clubs = $em->getRepository('AppBundle:Club')->findAll();
        return $this->render('AppBundle::apropos.html.twig', array(
                'clubs' => $clubs[0]
            )
        );
    }

    public function inscriptionAction(Request $request)
    {
        return $this->render('AppBundle::inscription.html.twig');
    }

    public function teamsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $teams = $em->getRepository('AccountBundle:Team')->findAll();
        return $this->render('AppBundle::teams.html.twig', array(
            'teams' => $teams
         ));
    }

    public function teamsShowAction(Team $team)
    {
        return $this->render('AppBundle:team:show.html.twig', array(
            'team' => $team,
        ));
    }

    public function contactAction()
    {
        return $this->render('AppBundle::contact.html.twig');
    }

    public function adminAction()
    {
        return $this->render('AppBundle::admin/index.html.twig');
    }
}
