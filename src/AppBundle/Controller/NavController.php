<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Club;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NavController extends Controller
{
    public function navbarAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('AccountBundle:Category')->findAll();
        $roles = $em->getRepository('AccountBundle:Role')->findBy([], ['roleName'=>'ASC']);

        return $this->render('AppBundle:admin/layout:nav.html.twig', [
                'categories' => $categories,
                'roles' => $roles,
        ]);
    }

}