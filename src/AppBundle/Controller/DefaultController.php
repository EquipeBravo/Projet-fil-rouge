<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AccountBundle\Entity\Person;
use AppBundle\Entity\Event;

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
                'clubs' => $clubs
            )
        );
    }

    public function inscriptionAction(Request $request)
    {
        return $this->render('AppBundle::inscription.html.twig');
    }

    public function teamsAction()
    {
        return $this->render('AppBundle::teams.html.twig');
    }

    public function contactAction()
    {
        return $this->render('AppBundle::contact.html.twig');
    }

    public function adminAction()
    {
        return $this->render('AppBundle::admin/index.html.twig');
    }

    public function searchAction(Request $request)
    {
        $search = trim($request->query->get('keyword'));

        $em = $this->getDoctrine()->getManager();

        $events = $em
            ->createQuery('select a.id, a.title, a.dateEvent from AppBundle:Event a WHERE a.title LIKE ?1')
            ->setParameter(1, '%' . $search . '%')
            ->getResult();

        return $this->render('AppBundle::index.html.twig', [
            'events' => $events,
        ]);
    }

}
