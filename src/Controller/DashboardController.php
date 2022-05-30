<?php

namespace App\Controller;

use App\Entity\Listes;
use App\Repository\ListesRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="app_dashboard")
     */
    public function index(?string $listId, SessionInterface $session, ListesRepository $listesRepository): Response
    {
        if (!$session->get('utilisateur')) {
            return $this->redirectToRoute('app_login');
        }

        $utilisateurList = $listesRepository->findBy(['Utilisateur' => $session->get('utilisateur')]);

        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'utilisateur' => $session->get('utilisateur'),
            'listes' => $utilisateurList,
            'listeDetails' => [$utilisateurList],
        ]);
    }

    /**
     * @Route("/dashboard/{listId}", name="app_dashboard_list")
     */

    public function listDetail(?string $listId, SessionInterface $session, ListesRepository $listesRepository): Response
    {
        if (!$session->get('utilisateur')) {
            return $this->redirectToRoute('app_login');
        }

        $utilisateurList = $listesRepository->findBy(['Utilisateur' => $session->get('utilisateur')]);

        $list = $listesRepository->find($listId);

        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'utilisateur' => $session->get('utilisateur'),
            'listes' => $utilisateurList,
            'listeDetails' => [$list],

        ]);
    }
}
