<?php

namespace App\Controller;

use App\Entity\Conference;
use App\Form\ConferenceType;
use App\Repository\ConferenceRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\Paginator;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/conference")
 */
class ConferenceController extends AbstractController
{
    /**
     * @Route("/", name="conference_index", methods={"GET"})
     * @param Request $request
     * @param Paginator $paginator
     * @param ConferenceRepository $conferenceRepository
     * @return Response
     */
    public function index(Request $request, PaginatorInterface $paginator, ConferenceRepository $conferenceRepository): Response
    {
        $pagination = $paginator->paginate(
            $conferenceRepository->listByUser($this->getUser()),
            $request->query->getInt('page', 1),
            10 /*limit per page*/
        );
        return $this->render('conference/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/new", name="conference_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $conference = new Conference();
        $conference->setOwner($this->getUser());
        $form = $this->createForm(ConferenceType::class, $conference);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($conference);
            $entityManager->flush();
            $this->addFlash('success', 'Konferans kayıt edilmiştir.');

            return $this->redirectToRoute('conference_index');
        }

        return $this->render('conference/new.html.twig', [
            'conference' => $conference,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/detail/{id}", name="conference_show", methods={"GET"})
     */
    public function show(Conference $conference): Response
    {
        return $this->render('conference/show.html.twig', [
            'conference' => $conference,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="conference_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Conference $conference): Response
    {
        $form = $this->createForm(ConferenceType::class, $conference);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Konferans kayıt edilmiştir.');

            return $this->redirectToRoute('conference_index');
        }

        return $this->render('conference/edit.html.twig', [
            'conference' => $conference,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="conference_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Conference $conference): JsonResponse
    {
        if ($this->isCsrfTokenValid('delete'.$conference->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($conference);
            $entityManager->flush();
            return new JsonResponse(['error' => false], Response::HTTP_OK);

        } else {
            return new JsonResponse(['error' => true], Response::HTTP_INTERNAL_SERVER_ERROR);
        }


    }
}
