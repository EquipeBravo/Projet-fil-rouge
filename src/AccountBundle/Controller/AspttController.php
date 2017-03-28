<?php

namespace AccountBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AccountBundle\Entity\Person;

class AspttController extends Controller
{
    public function registerAction(Request $request)
    {
        $person = new Person();
        $form = $this->createForm('AccountBundle\Form\PersonType', $person, [
            'admin' => false,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($person);
            $em->flush($person);

            return $this->redirectToRoute('app_homepage', array('id' => $person->getId()));
        }

        return $this->render('AccountBundle:asptt:register.html.twig', array(
            'person' => $person,
            'form' => $form->createView(),
        ));
    }

    public function loginAction(Request $request)
    {
        $person = new Person();
        $form = $this->createForm('AccountBundle\Form\PersonType', $person, [
            'admin' => false,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($person);
            $em->flush($person);

            return $this->redirectToRoute('app_homepage', array('id' => $person->getId()));
        }

        return $this->render('AppBundle::login.html.twig', array(
            'person' => $person,
            'form' => $form->createView(),
        ));
    }
}
