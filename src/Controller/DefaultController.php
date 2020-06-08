<?php

namespace App\Controller;

use App\Repository\ConferenceRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @param ConferenceRepository $conferenceRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, PaginatorInterface $paginator, ConferenceRepository $conferenceRepository)
    {
        $pagination = $paginator->paginate(
            $conferenceRepository->listDashboard(),
            $request->query->getInt('page', 1),
            10 /*limit per page*/
        );
        return $this->render('default/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }
}
