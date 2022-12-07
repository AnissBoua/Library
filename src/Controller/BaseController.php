<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(LivreRepository $livreRepository, Request $request): Response
    {
        $query = $livreRepository->createQueryBuilder('l')
                    ->orderBy('l.id', 'ASC')
                    ->getQuery();
        $paginator = new Paginator($query);
        $totalItems = count($paginator);

        $limit = 6;
        $page = 1;
        $pagesCount = ceil($totalItems / $limit);
        
        if ($request->query->get('page')) {
            $page = $request->query->get('page') == 0 ? 1 : $request->query->get('page');
            if ($page > $pagesCount) $page = $pagesCount;
        }

        $livres = $paginator
                ->getQuery()
                ->setFirstResult($limit * ($page ? $page - 1 : 0))
                ->setMaxResults($limit)
                ->getResult();
        
        return $this->render('base/index.html.twig', [
            'controller_name' => 'BaseController',
            'livres' => $livres,
            'page' => $page,
        ]);
    }
}
