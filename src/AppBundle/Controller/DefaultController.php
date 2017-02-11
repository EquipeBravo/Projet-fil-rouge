<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('AppBundle::index.html.twig');
    }

    public function aproposAction()
    {
    	return $this->render('AppBundle::apropos.html.twig');
    }

    public function inscriptionAction()
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
}
