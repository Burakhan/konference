<?php

namespace App\Controller;

use App\Entity\ConferenceInstitution;
use App\Form\ConferenceInstitutionType;
use App\Repository\ConferenceInstitutionRepository;
use Stof\DoctrineExtensionsBundle\Uploadable\UploadableManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/conference-institution")
 */
class ConferenceInstitutionController extends AbstractController
{
    /**
     * @Route("/", name="conference_institution_index", methods={"GET"})
     */
    public function index(ConferenceInstitutionRepository $conferenceInstitutionRepository): Response
    {
        return $this->render('conference_institution/index.html.twig', [
            'conference_institutions' => $conferenceInstitutionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="conference_institution_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $conferenceInstitution = new ConferenceInstitution();
        $form = $this->createForm(ConferenceInstitutionType::class, $conferenceInstitution);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($conferenceInstitution);
            $entityManager->flush();

            return $this->redirectToRoute('conference_institution_index');
        }

        return $this->render('conference_institution/new.html.twig', [
            'conference_institution' => $conferenceInstitution,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="conference_institution_show", methods={"GET"})
     */
    public function show(ConferenceInstitution $conferenceInstitution): Response
    {
        return $this->render('conference_institution/show.html.twig', [
            'conference_institution' => $conferenceInstitution,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="conference_institution_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ConferenceInstitution $conferenceInstitution): Response
    {
        $form = $this->createForm(ConferenceInstitutionType::class, $conferenceInstitution);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('conference_institution_index');
        }

        return $this->render('conference_institution/edit.html.twig', [
            'conference_institution' => $conferenceInstitution,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="conference_institution_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ConferenceInstitution $conferenceInstitution): Response
    {
        if ($this->isCsrfTokenValid('delete'.$conferenceInstitution->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($conferenceInstitution);
            $entityManager->flush();
        }

        return $this->redirectToRoute('conference_institution_index');
    }
}
