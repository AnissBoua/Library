<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function index( UserInterface $user, ManagerRegistry $doctrine): Response
    {    $em = $doctrine->getManager();
 
        $panier = $user->getPanier();
        $livres = $panier->getLivres();
 
        $userId = $user->getId();

        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController',
            'userID' => $userId,
            'livres'=> $livres,
            "panier" => $panier
        ]);
    }
}

