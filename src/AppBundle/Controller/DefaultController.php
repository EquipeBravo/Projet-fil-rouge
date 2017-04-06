<?php

namespace AppBundle\Controller;

use PlanningBundle\Entity\Matchs;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AccountBundle\Entity\Person;
use AccountBundle\Entity\Team;
use AppBundle\Entity\Event;

class DefaultController extends Controller
{

    /*
     * Affichage de la page principale
     * avec l'argument "$events" qui contient les évènements à afficher
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $eventsTemp = $em->getRepository('AppBundle:Event')->findBy(array(), array('dateEvent' => 'ASC'));
        $matchsTemp = $em->getRepository('PlanningBundle:Matchs')->findBy(array(), array('dateMatch' => 'ASC'));

        $date = new \DateTime("now");
        $events = null;
        $matchs = null;
        foreach ($eventsTemp as $event) {
            if ($event->getDateEvent() > $date) {
                $events[] = $event;
            }
        }

        foreach ($matchsTemp as $match) {
            if ($match->getDateMatch() > $date) {
                $matchs[] = $match;
            }
        }

        return $this->render('AppBundle::index.html.twig', [
            'events' => $events,
            'matchs' => $matchs,
        ]);
    }

    /*
     * Affichage de la page A propos
     * avec l'argument "$clubs" qui contient les informations
     * sur le club à afficher
     */
    public function aproposAction()
    {
        $em = $this->getDoctrine()->getManager();

        $clubs = $em->getRepository('AppBundle:Club')->findAll();

        foreach ($clubs as $club) {
            $club->setClubContent(nl2br(($club->getClubContent())));
        }

        return $this->render('AppBundle::apropos.html.twig', array(
                'clubs' => $clubs
            )
        );
    }

    public function showExceptionAction(Request $request)
    {
        return $this->render('AppBundle::404.html.twig');
    }

    /*
     * Affichage de la page statique "inscriptions au club"
     */
    public function inscriptionAction(Request $request)
    {
        return $this->render('AppBundle::inscription.html.twig');
    }

    /*
     * Affichage de la page principale des Plannings
     * Transfère à la fonction d'affichage par semaine
     * la date actuelle, plus précisément le numéro de semaine
     */
    public function planningsAction()
    {
        $year = date("Y");
        $day = date("d");
        $month = date("m");
        $searchDateMax = new \DateTime($day . '-' . $month . '-' . $year);
        $week = $searchDateMax->format("W");

        return $this->planningsWeekAction($week);
    }

    /*
     * Affichage de la page PAR SEMAINE des Plannings
     * Différente de la fonction précédente, permet de passer
     * à une semaine suivante ou précédente et d'afficher les matchs
     * dans cette semaine
     *
     * Arguments passés à la vue :
     * $matchs : Liste des matchs de la semaine courante
     * $year : Année actuelle
     * $week : Semaine actuelle
     */
    public function planningsWeekAction($week)
    {
        $year = date("Y");

        $daysInWeek = $this->getDaysInWeek($week, $year);
        $weekTitle = $this->getSundaySaturdayInWeek($week + 1, $year);

        $searchDate = new \DateTime();
        $searchDate->setTimestamp($daysInWeek[0]);

        $searchDateMax = new \DateTime();
        $searchDateMax->setTimestamp($daysInWeek[0]);
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
            } else {
                $match->setDomicile("À l'extérieur");
            }
        }


        return $this->render('AppBundle:plannings:plannings.html.twig', [
            'matchs' => $matchs,
            'year' => $year,
            'week' => $week,
            'weekTitle' => $weekTitle
        ]);
    }

    /*
     * Fonction permettant aux plannings de convertir
     * un numéro de semaine et une année en objet de type DateTime valide
     *
     * Ceci est utile à la fonction "planningsWeekAction" pour déterminer
     * son intervale de recherche (entre telle et telle semaine)
     */
    function getDaysInWeek($weekNumber, $year)
    {
        // Count from '0104' because January 4th is always in week 1
        // (according to ISO 8601).
        $time = strtotime($year . '0104 +' . ($weekNumber - 1)
            . ' weeks');
        // Get the time of the first day of the week
        $mondayTime = strtotime('-' . (date('w', $time) - 1) . ' days',
            $time);
        // Get the times of days 0 -> 6
        $dayTimes = array();
        for ($i = 0; $i < 7; ++$i) {
            $dayTimes[] = strtotime('+' . $i . ' days', $mondayTime);
        }
        // Return timestamps for mon-sun.
        return $dayTimes;
    }

    function getSundaySaturdayInWeek($week, $year)
    {
        $timestamp = mktime(0, 0, 0, 1, 1, $year) + ($week * 7 * 24 * 60 * 60);
        $timestamp_for_monday = $timestamp - 86400 * (date('N', $timestamp) - 1);
        $monday = date('Y-m-d', $timestamp_for_monday);
        $sunday = date('d/m', strtotime('-1 day', strtotime($monday)));
        $saturday = date('d/m', strtotime('-2 day', strtotime($monday)));
        $weekTitle = 'Du ' . $saturday . ' au ' . $sunday;
        return $weekTitle;
    }

    /*
     * Affichage de la page PAR ANNEE des Plannings
     * Différente des fonctions précédentes, permet de passer
     * à une année suivante ou précédente
     *
     * Arguments passés à la vue :
     * $matchs : Liste des matchs de l'année courante
     * $year : Année actuelle
     */
    public function planningsYearMenuAction()
    {
        return $this->planningsYearAction(date("Y"));
    }

    public function planningsYearAction($id)
    {
        $search = trim($id);

        $searchDate = new \DateTime($search . '-01-01');
        $searchDateMax = new \DateTime(($search + 1) . '-01-01');

        $matchs = $this->getDoctrine()
            ->getManager()
            ->createQuery('SELECT e FROM PlanningBundle:Matchs e WHERE e.dateMatch > ?1 AND e.dateMatch < ?2')
            ->setParameter(1, $searchDate)
            ->setParameter(2, $searchDateMax)
            ->getResult();

        foreach ($matchs as $match) {
            if ($match->getDomicile() == 1) {
                $match->setDomicile('À domicile');
            } else {
                $match->setDomicile("À l'extérieur");
            }
        }

        return $this->render('AppBundle:plannings:year.html.twig', array(
            'matchs' => $matchs,
            'year' => $search
        ));
    }

    /*
     * Affichage de la page TEAM publique
     * Permet d'afficher les équipes dans la partie publique du site
     *
     * Arguments passés à la vue :
     * $teams : contient la liste des équipes à afficher
     */
    public function teamsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $teams = $em->getRepository('AccountBundle:Team')->findAll();
        return $this->render('AppBundle::teams.html.twig', array(
            'teams' => $teams
        ));
    }

    /*
     * Affichage de la page publique de détails d'une TEAM
     * Permet d'afficher une équipe et ses informations
     *
     * Arguments passés à la vue :
     * $team : contient l'équipe dont on va afficher les infos
     */
    public function teamsShowAction(Team $team)
    {
        return $this->render('AppBundle:team:show.html.twig', array(
            'team' => $team,
        ));
    }

    /*
     * Affichage de la page publique de détails d'un EVENT
     * Permet d'afficher un évènement et ses informations
     *
     * Arguments passés à la vue :
     * $event : contient l'évènement dont on va afficher les infos
     */
    public function eventShowAction(Event $event)
    {
        return $this->render('AppBundle:public:eventShow.html.twig', array(
            'event' => $event,
        ));
    }

    /*
     * Affichage de la page publique de détails d'un MATCH
     * Permet d'afficher un match et ses informations
     *
     * Arguments passés à la vue :
     * $match : contient le match dont on va afficher les infos
     */
    public function matchShowAction(Matchs $match)
    {
        $team1 = $match->getTeam();
        $team2 = $match->getTeam2();

        $em = $this->getDoctrine()->getManager();

        $role = $em->getRepository('AccountBundle:Role')->findBy(['roleName' => 'Joueur']);
        $players1 = $em->getRepository('AccountBundle:Person')
            ->createQueryBuilder('p')
            ->join('p.teams', 't')
            ->join('p.userRoles', 'r')
            ->where('t = :team')
            ->andwhere('r= :role')
            ->setParameter('team', $team1)
            ->setParameter('role', $role)
            ->orderBy('p.lastName', 'ASC')
            ->getQuery()
            ->getResult();

        $players2 = $em->getRepository('AccountBundle:Person')
            ->createQueryBuilder('p')
            ->join('p.teams', 't')
            ->join('p.userRoles', 'r')
            ->where('t = :team')
            ->andwhere('r= :role')
            ->setParameter('team', $team2)
            ->setParameter('role', $role)
            ->orderBy('p.lastName', 'ASC')
            ->getQuery()
            ->getResult();

        return $this->render('AppBundle:public:matchShow.html.twig', array(
            'match' => $match,
            'team1' => $team1,
            'team2' => $team2,
            'players1' => $players1,
            'players2' => $players2,
        ));
    }

    /*
     * Affichage de la page publique de la galerie photo d'une équipe
     * Permet d'afficher les photos d'une équipe
     *
     * Arguments passés à la vue :
     * $team : contient l'équipe dont on va afficher les photos
     * $files : contient les photos à afficher
     */
    public function teamsGalleryAction(Team $team)
    {
        $em = $this->getDoctrine()->getManager();
        $files = $em->getRepository('GalleryBundle:File')->findBy(['team' => $team], ['uploadDate' => 'DESC']);

        return $this->render('AppBundle:team:gallery.html.twig', array(
            'team' => $team,
            'files' => $files
        ));
    }

    /*
     * Affichage de la page publique des Contacts
     * Permet d'afficher les contacts du Club et un
     * formulaire de contact qui envoie un mail avec le
     * contenu du formulaire sur une adresse mail
     *
     * Arguments passés à la vue :
     * form : Contient le formulaire permettant d'envoyer un mail de contact
     */
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

        $em = $this->getDoctrine()->getManager();

        //one can also create a new entity Personal (president, manager, secretariat ...)

        $roleNames = ['Président', 'Trésorier', 'Arbitre', 'Entraîneur'];

        foreach ($roleNames as $roleName) {
            $persons = $em->getRepository('AccountBundle:Person')
                ->createQueryBuilder('p')
                ->join('p.userRoles', 'r')
                ->where('r.roleName= :role')
                ->setParameter('role', $roleName)
                ->getQuery()
                ->getResult();

            //$persons['roleName']= $roleName;
            $roles[] = $persons;
        }

        //$roles = [$president, $treasurer, $arbiter, $coach];

        return $this->render('AppBundle::contact.html.twig', array(
            'form' => $form->createView(),
            'roleNames' => $roleNames,
            'roles' => $roles,
        ));
    }

    /*
     * Cette fonction est liée à la fonction contactAction
     * Elle permet l'envoi de mail avec les données reçues
     * depuis le formulaire de la page Contacts
     */
    private function sendEmail($data)
    {
        $myappContactMail = 'asptt.imie@gmail.com';
        $myappContactPassword = 'asptt1993';

        $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
            ->setUsername($myappContactMail)
            ->setPassword($myappContactPassword);

        $mailer = \Swift_Mailer::newInstance($transport);

        $message = \Swift_Message::newInstance("[Site Asptt] Formulaire de contact : " . $data["subject"])
            ->setFrom(array($myappContactMail => "Nouveau message de " . $data["name"]))
            ->setTo(array(
                $myappContactMail => $myappContactMail
            ))
            ->setBody($data["message"] . "\n\rEmail de contact :" . $data["email"]);

        return $mailer->send($message);
    }

    /*
     * Renvoie sur l'interface Administrateur
     */
    public function adminAction()
    {
        return $this->render('AppBundle::admin/index.html.twig');
    }

    /* Fonction RECHERCHE
     * Affichage de la page d'accueil avec les résultats
     * de la recherche.
     *
     * Permet d'afficher les matchs, les évènements et les
     * équipes correspondant au mot clé envoyé par le formulaire
     * de recherche présent sur la page d'accueil
     *
     * Arguments passés à la vue :
     *  events : contient la liste des résultats, on la nommera events pour
     * garder la même logique d'affichage que pour l'affichage de la page d'accueil
     * search : contient un booléen qui indiquera à la vue que l'on est en mode RECHERCHE
     * keyword : contient le mot clé entré par l'utilisateur pendant sa recherche
     */
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
            $event->setDateEvent($team['trainingDay'] . ' à ' . $team['trainingTime']);
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


            $event->setTitle('Match ' . $team1[0]['name'] . ' contre ' . $team2[0]['name']);
            $events[] = $event;
        }

        return $this->render('AppBundle::index.html.twig', [
            'events' => $events,
            'search' => true,
            'keyword' => $search,
        ]);
    }
}
