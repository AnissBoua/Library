<?php

namespace App\Controller;

use App\Entity\PanierItem;
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
        $panierItems = $panier->getPanierItems();
 
        $livres = array();
        $total = 0;
        foreach ($panierItems as $item) {
            $livre = $item->getLivre();
            array_push($livres, $livre);
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
        $items = $panier->getPanierItems();
        
        $inPanier =  $items->filter(function($element) use ($livre) {
            // deja dans le panier
            if ($element->getLivre()->getId() === $livre->getId()) {
                return $element;
            }
        });
        
        // deja dans le panier
        if ($inPanier->isEmpty()) {
            $panierItem = new PanierItem();

            $panierItem->setPanier($panier);
            $panierItem->setLivre($livre);
            $panierItem->setQuantity(1); // TODO

            $this->entityManager->persist($panierItem);
            $this->entityManager->flush();
        } else {
            $panierItem = $inPanier->first();
            $panierItem->setQuantity($panierItem->getQuantity() + 1); //TODO
            $this->entityManager->persist($panierItem);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('app_livre_index');
    }
}

