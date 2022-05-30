<?php

namespace App\Controller;

use App\Entity\Taches;
use App\Repository\ListesRepository;
use App\Repository\TachesRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class TachesController extends AbstractController
{
    /**
     * @Route("/taches", name="creer_tache", methods={"POST"})
     */
    public function create(Request $request, ManagerRegistry $registry, Session $session, ListesRepository $listesRepository): JsonResponse
    {
        if(!$request->request->get('nom')) {
            return new JsonResponse(['error' => 'Veuillez renseigner un nom'], Response::HTTP_BAD_REQUEST);
        }

        $task = new Taches();
        $task->setNom($request->request->get('nom'));
        $task->setPriority($request->request->get('priority'));
        $task->setListes($listesRepository->find($request->request->get('liste')));

        $entityManager = $registry->getManager();
        $entityManager->persist($task);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Tache créée'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/taches", name="supprimer_tache", methods={"DELETE"})
     */
    public function delete(Request $request, ManagerRegistry $registry, SessionInterface $session, TachesRepository $tachesRepository): JsonResponse
    {
        if(!$request->request->get('tacheId')) {
            return new JsonResponse(['error' => 'Veuillez renseigner une liste'], Response::HTTP_BAD_REQUEST);
        }

        $list = $tachesRepository->find($request->request->get('tacheId'));

        $entityManager = $registry->getManager();
        $entityManager->remove($list);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Tâche supprimée'], Response::HTTP_CREATED);

    }


    /**
     * @Route("/taches", name="patch_tache", methods={"PATCH"})
     */
    public function patch(Request $request, ManagerRegistry $registry, Session $session, TachesRepository $tachesRepository): JsonResponse
    {
        $task = $tachesRepository->find($request->request->get('tacheId'));

        $task->setActive(!$task->getActive());
        $entityManager = $registry->getManager();
        $entityManager->persist($task);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Tâche mise à jour'], Response::HTTP_CREATED);

    }
}