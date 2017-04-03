<?php

namespace AccountBundle\Controller;

use AccountBundle\Entity\Person;
use AccountBundle\Entity\Role;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Person controller.
 *
 */
class PersonController extends Controller
{
    /**
     * Lists all person entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $people = $em->getRepository('AccountBundle:Person')->findAll();

        return $this->render('AccountBundle:person:index.html.twig', array(
            'people' => $people,
        ));
    }

    /**
     * Creates a new person entity.
     *
     */
    public function newAction(Request $request)
    {
        $person = new Person();
        $form = $this->createForm('AccountBundle\Form\PersonType', $person);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($person);
            $em->flush($person);

            return $this->redirectToRoute('person_show', array('id' => $person->getId()));
        }

        return $this->render('AccountBundle:person:new.html.twig', array(
            'person' => $person,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a person entity.
     *
     */
    public function showAction(Person $person)
    {
        $deleteForm = $this->createDeleteForm($person);

        return $this->render('AccountBundle:person:show.html.twig', array(
            'person' => $person,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing person entity.
     *
     */
    public function editAction(Request $request, Person $person)
    {
        $password = $person->getPassword();
        $deleteForm = $this->createDeleteForm($person);
        $editForm = $this->createForm('AccountBundle\Form\PersonType', $person);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $person->setPassword($password);
            $this->getDoctrine()->getManager()->flush($person);

            return $this->redirectToRoute('person_show', array('id' => $person->getId()));
        }

        return $this->render('AccountBundle:person:edit.html.twig', array(
            'person' => $person,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a person entity.
     *
     */
    public function deleteAction(Request $request, Person $person)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AccountBundle:Person')->find($person);

        if (!$entity) {
            throw $this->createNotFoundException('ERROR : No such entity');
        }

        $em->remove($entity);
        $em->flush();


        return $this->redirectToRoute('person_index');
    }

    public function profileAction(Person $person)
    {
        $deleteForm = $this->createDeleteForm($person);

        return $this->render('AccountBundle:user:profile.html.twig', array(
            'person' => $person,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to delete a person entity.
     *
     * @param Person $person The person entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Person $person)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('person_delete', array('id' => $person->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Finds people by their role
     *
     * @param Role $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function sortByRoleAction(Role $role)
    {
        $em = $this->getDoctrine()->getManager();

        $people = $em ->getRepository('AccountBundle:Person')
            ->createQueryBuilder('p')
            ->join('p.userRoles', 'r')
            ->where('r = :role')
            ->setParameter('role', $role)
            ->orderBy('p.lastName', 'ASC')
            ->getQuery()
            ->getResult();

        return $this->render('AccountBundle:person:index.html.twig', array(
            'role' => $role,
            'people' => $people,
        ));
    }
}
