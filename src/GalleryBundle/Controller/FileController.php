<?php

namespace GalleryBundle\Controller;

use GalleryBundle\Entity\File;
use GalleryBundle\Form\FileType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * File controller.
 *
 */
class FileController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $files = $em->getRepository('GalleryBundle:File')->findAll();

        return $this->render('GalleryBundle:file:index.html.twig', array(
            'files' => $files,
        ));
    }

    /**
     * @Route("/admin/gallery/new", name="app_file_new")
     */

    public function newAction(Request $request)
    {

        $file = new File();
        $form = $this->createForm('GalleryBundle\Form\FileType', $file);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $fileUpload = $file->getFiles();
            $fileName = md5(uniqid()).'.'.$fileUpload->guessExtension();
            $fileUpload->move(
                $this->getParameter('files_directory'),
                $fileName
            );
            $file->setFiles($fileName);
            $em->persist($file);
            $em->flush($file);

            return $this->redirect($this->generateUrl('file_show', array(
                'id' => $file->getId(),
            )));
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
            $em = $this->getDoctrine()->getManager();
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $fileUpload = $file->getFiles();
            $fileName = md5(uniqid()).'.'.$fileUpload->guessExtension();
            $fileUpload->move(
                $this->getParameter('files_directory'),
                $fileName
            );
            $file->setFiles($fileName);
            $em->persist($file);
            $em->flush($file);

            return $this->redirect($this->generateUrl('file_show', array(
                'id' => $file->getId(),
            )));
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
