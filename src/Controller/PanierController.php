<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/panier', name: 'app_panier')]
    public function index( UserInterface $user, ManagerRegistry $doctrine): Response
    {    
        $em = $doctrine->getManager();

        $panier = $user->getPanier();
        $livres = $panier->getLivres();
 
        $total = 0;
        foreach ($livres as $livre) {
            $total += $livre->getPrix();
        }
        
        $userId = $user->getId();

        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController',
            'userID' => $userId,
            'livres'=> $livres,
            "panier" => $panier,
            'total' => $total,
        ]);
    }

    #[Route('/panier/ajout', name: 'app_panier_ajout', methods: ['POST'])]
    public function ajout( UserInterface $user, LivreRepository $livreRepository, ManagerRegistry $doctrine, Request $request)
    {    
        $livre = $livreRepository->find($request->request->get('idLivre'));
        $panier = $user->getPanier();
        $panier->addLivre($livre);
        $this->entityManager->persist($panier);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_livre_index');
    }
}

