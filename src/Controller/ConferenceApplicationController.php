<?php

namespace App\Controller;

use App\Entity\Conference;
use App\Entity\ConferenceApplication;
use App\Entity\ApplicationFiles;
use App\Form\ConferenceApplicationFilesType;
use App\Form\ConferenceApplicationType;
use App\Repository\ConferenceApplicationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/conference-application")
 */
class ConferenceApplicationController extends AbstractController
{
    /**
     * @Route("/", name="conference_application_index", methods={"GET"})
     */
    public function index(ConferenceApplicationRepository $conferenceApplicationRepository): Response
    {
        return $this->render('conference_application/index.html.twig', [
            'conference_applications' => $conferenceApplicationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{conference}", name="conference_application_new", methods={"GET","POST"})
     * @param Request $request
     * @param Conference $conference
     * @return Response
     */
    public function new(Request $request, Conference $conference): Response
    {
        $conferenceApplication = new ConferenceApplication();
        $form = $this->createForm(ConferenceApplicationType::class, $conferenceApplication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $conferenceApplication->setApplicationUser($this->getUser());
            $conferenceApplication->setConference($conference);
            $conferenceApplication->setStatus(ConferenceApplication::STATUS_DRAFT);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($conferenceApplication);
            $entityManager->flush();

            return $this->redirectToRoute('conference_application_index');
        }

        return $this->render('conference_application/new.html.twig', [
            'conference_application' => $conferenceApplication,
            'form' => $form->createView(),
            'conference' => $conference,
        ]);
    }

    /**
     * @Route("/{id}", name="conference_application_show", methods={"GET"})
     */
    public function show(ConferenceApplication $conferenceApplication): Response
    {
        return $this->render('conference_application/show.html.twig', [
            'conference_application' => $conferenceApplication,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="conference_application_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ConferenceApplication $conferenceApplication): Response
    {
        $form = $this->createForm(ConferenceApplicationType::class, $conferenceApplication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('conference_application_index');
        }

        return $this->render('conference_application/edit.html.twig', [
            'conference_application' => $conferenceApplication,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="conference_application_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ConferenceApplication $conferenceApplication): Response
    {
        if ($this->isCsrfTokenValid('delete' . $conferenceApplication->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($conferenceApplication);
            $entityManager->flush();
        }

        return $this->redirectToRoute('conference_application_index');
    }
}
