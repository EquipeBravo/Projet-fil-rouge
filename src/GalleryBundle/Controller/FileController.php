<?php

namespace GalleryBundle\Controller;

use GalleryBundle\Entity\File;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * File controller.
 *
 */
class FileController extends Controller
{
    /**
     * Lists all file entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $files = $em->getRepository('GalleryBundle:File')->findAll();

        return $this->render('GalleryBundle:file:index.html.twig', array(
            'files' => $files,
        ));
    }

    /**
     * Creates a new file entity.
     *
     */
    public function newAction(Request $request)
    {
        $file = new File();
        $form = $this->createForm('GalleryBundle\Form\FileType', $file);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($file);
            $em->flush($file);

            return $this->redirectToRoute('file_show', array('id' => $file->getId()));
        }

        return $this->render('GalleryBundle:file:new.html.twig', array(
            'file' => $file,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a file entity.
     *
     */
    public function showAction(File $file)
    {
        $deleteForm = $this->createDeleteForm($file);

        return $this->render('GalleryBundle:file:show.html.twig', array(
            'file' => $file,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing file entity.
     *
     */
    public function editAction(Request $request, File $file)
    {
        $deleteForm = $this->createDeleteForm($file);
        $editForm = $this->createForm('GalleryBundle\Form\FileType', $file);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('file_edit', array('id' => $file->getId()));
        }

        return $this->render('GalleryBundle:file:edit.html.twig', array(
            'file' => $file,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a file entity.
     *
     */
    public function deleteAction(Request $request, File $file)
    {
        $form = $this->createDeleteForm($file);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($file);
            $em->flush($file);
        }

        return $this->redirectToRoute('file_index');
    }

    /**
     * Creates a form to delete a file entity.
     *
     * @param File $file The file entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(File $file)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('file_delete', array('id' => $file->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}