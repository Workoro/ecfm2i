<?php

namespace App\Controller;

use App\Entity\Produit;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    #[Route('/', name: 'Accueil')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $produitsRP = $entityManager->getRepository(Produit::class);
        $produits = $produitsRP->findAll();
        dump($produits);
        return $this->render('blog/index.html.twig', [
            'produits' => $produits
        ]);
    }
    #[Route('/produits/{id}', name: 'show')]
    public function show($id, ManagerRegistry $doctrine, Request $request): Response
    {
        // $session = new Session();
        // $session->start();
        $entityManager = $doctrine->getManager();
        $produitsRP = $entityManager->getRepository(Produit::class);
        $produit = $produitsRP->findOneById($id);
        dump($produit);
        // if ($request->request->get('ajout')) {
        //     $quantite = $request->request->get('quantite');
        //     $produit2 = $request->request->get('produit');
        //     $session->set('quantite', $quantite);
        //     $session->set('produit', $produit2);
        // }
        return $this->render('blog/lecture.html.twig', [
            'produit' => $produit,

        ]);
    }
    #[Route('/panier', name: 'Panier')]
    public function panier(): Response
    {
        // $quantite = $request->getSession('quantite');
        // $produitid = $request->getSession('produit');
        return $this->render('blog/panier.html.twig');
        // , [
        //     'quantite' => $quantite,
        //     'produit' => $produitid,
        // ]);
    }
    public function menu()
    {
        $listMenu = [
            ['title' => 'Mon blog', 'texte' => 'Acceuil', 'url' => $this->generateUrl('Accueil')],
            ['title' => 'Panier', 'texte' => 'Panier', 'url' => $this->generateUrl('Panier'), "user" => false],



        ];
        return $this->render("parts/menu.html.twig", ["listMenu" => $listMenu]);
    }
}
