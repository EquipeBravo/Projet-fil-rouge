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
        $year = date("Y");
        $day = date("d");
        $month = date("m");

        $searchDate = new \DateTime($year.'-01-01');
        $searchDateMax = new \DateTime( $day.'-'.$month.'-'.$year );
        $searchDateMax->add(new \DateInterval('P5D'));

        $week = $searchDateMax->format("W");

        $matchs = $this->getDoctrine()
            ->getManager()
            ->createQuery('SELECT e FROM PlanningBundle:Matchs e WHERE e.dateMatch > ?1 AND e.dateMatch < ?2')
            ->setParameter(1, $searchDate)
            ->setParameter(2, $searchDateMax)
            ->getResult();

        foreach ($matchs as $match) {
            if ($match->getDomicile() == 1) {
                $match->setDomicile('À domicile');
            }
            else {
                $match->setDomicile("À l'extérieur");
            }
        }

        return $this->render('AppBundle:plannings:plannings.html.twig', [
            'matchs' => $matchs,
            'year' => $year,
            'week' => $week
        ]);
    }

    public function planningsWeekAction($week)
    {
        $year = date("Y");

        $test = $this->getDaysInWeek($week-1,$year);

        $searchDate = new \DateTime();
        $searchDate->setTimestamp($test[0]);

        $searchDateMax = new \DateTime();
        $searchDateMax->setTimestamp($test[0]);
        $searchDateMax->add(new \DateInterval('P7D'));

        $matchs = $this->getDoctrine()
            ->getManager()
            ->createQuery('SELECT e FROM PlanningBundle:Matchs e WHERE e.dateMatch > ?1 AND e.dateMatch < ?2')
            ->setParameter(1, $searchDate)
            ->setParameter(2, $searchDateMax)
            ->getResult();

        foreach ($matchs as $match) {
            if ($match->getDomicile() == 1) {
                $match->setDomicile('À domicile');
            }
            else {
                $match->setDomicile("À l'extérieur");
            }
        }

        return $this->render('AppBundle:plannings:plannings.html.twig', [
            'matchs' => $matchs,
            'year' => $year,
            'week' => $week
        ]);
    }

    function getDaysInWeek ($weekNumber, $year) {
        // Count from '0104' because January 4th is always in week 1
        // (according to ISO 8601).
        $time = strtotime($year . '0104 +' . ($weekNumber - 1)
            . ' weeks');
        // Get the time of the first day of the week
        $mondayTime = strtotime('-' . (date('w', $time) - 1) . ' days',
            $time);
        // Get the times of days 0 -> 6
        $dayTimes = array ();
        for ($i = 0; $i < 7; ++$i) {
            $dayTimes[] = strtotime('+' . $i . ' days', $mondayTime);
        }
        // Return timestamps for mon-sun.
        return $dayTimes;
    }

    public function planningsYearAction($id)
    {
        $search = trim($id);

        $searchDate = new \DateTime($search.'-01-01');
        $searchDateMax = new \DateTime(($search+1).'-01-01');

        $matchs = $this->getDoctrine()
            ->getManager()
            ->createQuery('SELECT e FROM PlanningBundle:Matchs e WHERE e.dateMatch > ?1 AND e.dateMatch < ?2')
            ->setParameter(1, $searchDate)
            ->setParameter(2, $searchDateMax)
            ->getResult();

        foreach ($matchs as $match) {
            if ($match->getDomicile() == 1) {
                $match->setDomicile('À domicile');
            }
            else {
                $match->setDomicile("À l'extérieur");
            }
        }

        return $this->render('AppBundle:plannings:year.html.twig', array(
            'matchs' => $matchs,
            'year' => $search
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
            ->createQuery('select a.id, a.title, a.dateEvent from AppBundle:Event a WHERE a.title LIKE ?1 OR a.dateEvent LIKE ?1')
            ->setParameter(1, '%' . $search . '%')
            ->getResult();

        $teams = $em
            ->createQuery('select a.id, a.name, a.trainingTime, a.trainingDay from AccountBundle:Team a WHERE a.name LIKE ?1')
            ->setParameter(1, '%' . $search . '%')
            ->getResult();

        if ($search === "équipe" || $search === "equipe" || $search === "equipes" || $search === "équipes" || $search === "Equipe" || $search === "Equipes" || $search === "team" || $search === "teams" || $search === "Teams" || $search === "Team" || $search === "Équipe" || $search === "Équipes") {
            $teams = $em
                ->createQuery('select a.id, a.name, a.trainingTime, a.trainingDay from AccountBundle:Team a')
                ->getResult();
        }

        foreach ($teams as $team) {
            $event = new Event();
            $event->setDateEvent($team['trainingDay'].' à '.$team['trainingTime']);
            $event->setId($team['id']);
            $event->team = true;

            $event->setTitle($team['name']);
            $events[] = $event;
        }

        $matchs = $em
            ->createQuery('select a.id, a.dateMatch, IDENTITY(a.team), IDENTITY(a.team2) from PlanningBundle:Matchs a WHERE a.dateMatch LIKE ?1')
            ->setParameter(1, '%' . $search . '%')
            ->getResult();

        if ($search === "match" || $search === "Match" || $search === "matchs" || $search === "Matchs") {
            $matchs = $em
                ->createQuery('select a.id, a.dateMatch, IDENTITY(a.team), IDENTITY(a.team2) from PlanningBundle:Matchs a')
                ->getResult();
        }

        foreach ($matchs as $match) {
            $event = new Event();
            $event->setId($match['id']);
            $event->setDateEvent($match['dateMatch']);
            $event->match = true;

            $team1 = $em
                ->createQuery('select a.id, a.name from AccountBundle:Team a WHERE a.id = ?1')
                ->setParameter(1, $match['1'])
                ->getResult();

            $team2 = $em
                ->createQuery('select a.id, a.name from AccountBundle:Team a WHERE a.id = ?1')
                ->setParameter(1, $match['2'])
                ->getResult();


            $event->setTitle('Match '.$team1[0]['name'].' contre '.$team2[0]['name']);
            $events[] = $event;
        }

        return $this->render('AppBundle::index.html.twig', [
            'events' => $events,
        ]);
    }
}
