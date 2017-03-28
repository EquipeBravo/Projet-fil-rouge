<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AccountBundle\Entity\Person;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('AppBundle::index.html.twig');
    }

    public function aproposAction()
    {
        $em = $this->getDoctrine()->getManager();

        $clubs = $em->getRepository('AppBundle:Club')->findAll();

        if (!empty($clubs)) {
            $clubs = $clubs[0];
        }
        else {
            $clubs[0] = '';
        }

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
        return $this->render('AppBundle::teams.html.twig');
    }

    public function contactAction()
    {
        return $this->render('AppBundle::contact.html.twig');
    }

    public function loginAction()
    {
        return $this->render('AppBundle::login.html.twig');
    }

    public function adminAction()
    {
        return $this->render('AppBundle::admin/index.html.twig');
    }

}