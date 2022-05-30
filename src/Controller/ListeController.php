<?php

namespace App\Controller;

use App\Entity\Listes;
use App\Repository\ListesRepository;
use App\Repository\TachesRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ListeController extends AbstractController
{
    /**
     * @Route("/liste/{listId}", name="app_liste_list")
     */
    public function listDetail(?string $listId, SessionInterface $session, ListesRepository $listesRepository): Response
    {
        $utilisateurList = $listesRepository->findBy(['Utilisateur' => $session->get('utilisateur')]);

        $list = $listesRepository->find($listId);

        return $this->render('liste/index.html.twig', [
            'controller_name' => 'ListeController',
            'utilisateur' => $session->get('utilisateur'),
            'listes' => $utilisateurList,
            'listeDetails' => $list,

        ]);
    }

    /**
     * @Route("/liste", name="nouvelle_liste", methods={"POST"})
     */
    public function create(Request $request, ManagerRegistry $registry, SessionInterface $session, UtilisateurRepository $utilisateurRepository): JsonResponse
    {
        if (!$request->request->get('nom')) {
            return new JsonResponse(['error' => 'Veuillez renseigner un nom'], Response::HTTP_BAD_REQUEST);
        }

        $list = new Listes();
        $list->setNom($request->request->get('nom'));
        $list->setUtilisateur($utilisateurRepository->find($session->get('utilisateur')->getId()));

        $entityManager = $registry->getManager();
        $entityManager->persist($list);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Liste créée'], Response::HTTP_CREATED);

    }

    /**
     * @Route("/liste", name="supprimer_liste", methods={"DELETE"})
     */
    public function delete(Request $request, ManagerRegistry $registry, SessionInterface $session, ListesRepository $listesRepository): JsonResponse
    {
        if (!$request->request->get('listId')) {
            return new JsonResponse(['error' => 'Veuillez renseigner une liste'], Response::HTTP_BAD_REQUEST);
        }

        $list = $listesRepository->find($request->request->get('listId'));

        $entityManager = $registry->getManager();
        $entityManager->remove($list);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Liste supprimée'], Response::HTTP_CREATED);

    }

}