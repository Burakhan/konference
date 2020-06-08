<?php

namespace App\Controller;

use App\Entity\ApplicationFiles;
use App\Entity\ConferenceApplication;
use App\Form\ApplicationFilesType;
use App\Repository\ApplicationFilesRepository;
use App\Repository\FileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/conference-application-files")
 */
class ApplicationFilesController extends AbstractController
{
    /**
     * @Route("/{conferenceApplication}/new", name="application_files_new", methods={"GET","POST"})
     * @param Request $request
     * @param ConferenceApplication $conferenceApplication
     * @param ApplicationFilesRepository $applicationFilesRepository
     * @return Response
     */
    public function new(Request $request, ConferenceApplication $conferenceApplication, ApplicationFilesRepository $applicationFilesRepository): Response
    {
        $applicationFile = new ApplicationFiles();
        $form = $this->createForm(ApplicationFilesType::class, $applicationFile);
        $form->handleRequest($request);
        $fileList = $applicationFilesRepository->getFiles($conferenceApplication);
        if ($form->isSubmitted() && $form->isValid()) {
            $applicationFile->setConferenceApplication($conferenceApplication);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($applicationFile);
            $entityManager->flush();

            return $this->redirectToRoute('application_files_new', ['conferenceApplication' => $conferenceApplication->getId()]);
        }

        return $this->render('application_files/new.html.twig', [
            'application_file' => $applicationFile,
            'conference' => $conferenceApplication->getConference(),
            'form' => $form->createView(),
            'fileList' => $fileList,
        ]);
    }

    /**
     * @Route("/{id}", name="application_files_show", methods={"GET"})
     */
    public function show(ApplicationFiles $applicationFile): Response
    {
        return $this->render('application_files/show.html.twig', [
            'application_file' => $applicationFile,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="application_files_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ApplicationFiles $applicationFile): Response
    {
        $form = $this->createForm(ApplicationFilesType::class, $applicationFile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('application_files_index');
        }

        return $this->render('application_files/edit.html.twig', [
            'application_file' => $applicationFile,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="application_files_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ApplicationFiles $applicationFile): Response
    {
        if ($this->isCsrfTokenValid('delete'.$applicationFile->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($applicationFile);
            $entityManager->flush();
        }

        return $this->redirectToRoute('application_files_index');
    }
}
