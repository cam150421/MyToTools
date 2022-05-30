<?php

namespace App\Controller;

use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;


class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function index(Request $request, UtilisateurRepository $utilisateurRepository, SessionInterface $sessionInterface): Response
    {
        if ($sessionInterface->get('utilisateur')) {
            return $this->redirectToRoute('app_dashboard');
        }


        if ($request->getMethod() == 'POST') {
            $identifiant = $request->get('identifiant');
            $utilisateur = $utilisateurRepository->findOneBy(['login' => $identifiant]);

            if ($utilisateur != null) {
                $sessionInterface->set('utilisateur', $utilisateur);
                return $this->redirectToRoute('app_dashboard');
            }

            $this->addFlash('error', "Email incorrect");
        }


        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(SessionInterface $session) {
        $session->clear();
        return $this->redirectToRoute('app_login');

    }
}