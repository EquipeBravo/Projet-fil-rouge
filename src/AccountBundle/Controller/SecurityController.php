<?php

namespace AccountBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AccountBundle\Entity\Person;

class SecurityController extends Controller
{
    public function registerAction(Request $request)
    {
        $person = new Person();
        $form = $this->createForm('AccountBundle\Form\PersonType', $person, [
            'admin' => false,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //crypt password
            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($person, $person->getPassword());
            $person->setPassword($encoded);

            $em = $this->getDoctrine()->getManager();
            $em->persist($person);
            $em->flush($person);

            return $this->redirectToRoute('app_login');
        }

        return $this->render('AccountBundle:security:register.html.twig', array(
            'person' => $person,
            'form' => $form->createView(),
        ));
    }

    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $email = $authenticationUtils->getLastUsername();

        return $this->render('AccountBundle:security:login.html.twig', array(
            'last_username' => $email,
            'error'         => $error,
        ));
    }
}
