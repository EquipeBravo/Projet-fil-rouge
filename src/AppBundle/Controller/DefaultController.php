<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AccountBundle\Entity\Person;
use AccountBundle\Entity\Team;
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

    public function planningsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $matchs = $em->getRepository('PlanningBundle:Matchs')->findAll();

        foreach ($matchs as $match) {
            if ($match->getDomicile() == 1) {
                $match->setDomicile('À domicile');
            }
            else {
                $match->setDomicile("À l'extérieur");
            }
        }

        return $this->render('AppBundle:plannings:plannings.html.twig', array(
            'matchs' => $matchs
        ));
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

    public function teamsGalleryAction(Team $team)
    {
        $em = $this->getDoctrine()->getManager();
        $files = $em->getRepository('GalleryBundle:File')->findBy(['team' => $team], ['uploadDate' => 'DESC']);

        return $this->render('AppBundle:team:gallery.html.twig', array(
            'team' => $team,
            'files' => $files
        ));
    }

    public function contactAction(Request $request)
    {
        // Create the form according to the FormType created previously.
        // And give the proper parameters
        $form = $this->createForm('AppBundle\Form\ContactType', null, array(
            // To set the action use $this->generateUrl('route_identifier')
            'action' => $this->generateUrl('app_contact'),
            'method' => 'POST'
        ));

        if ($request->isMethod('POST')) {
            // Refill the fields in case the form is not valid.
            $form->handleRequest($request);

            if ($form->isValid()) {
                // Send mail
                if ($this->sendEmail($form->getData())) {

                    // Everything OK, redirect to wherever you want ! :

                    return $this->redirectToRoute('app_contact');
                } else {
                    // An error ocurred, handle
                    var_dump("Une erreur est survenue, veuillez recharger la page.");
                }
            }
        }
        return $this->render('AppBundle::contact.html.twig', array(
            'form' => $form->createView()
        ));
    }

    private function sendEmail($data)
    {
        $myappContactMail = 'asptt.imie@gmail.com';
        $myappContactPassword = 'asptt1993';

        $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
            ->setUsername($myappContactMail)
            ->setPassword($myappContactPassword);

        $mailer = \Swift_Mailer::newInstance($transport);

        $message = \Swift_Message::newInstance("[Site Asptt] Formulaire de contact : ". $data["subject"])
            ->setFrom(array($myappContactMail => "Nouveau message de ".$data["name"]))
            ->setTo(array(
                $myappContactMail => $myappContactMail
            ))
            ->setBody($data["message"]."\n\rEmail de contact :".$data["email"]);

        return $mailer->send($message);
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
