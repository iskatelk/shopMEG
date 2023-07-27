<?php

namespace App\Controller;

use App\Entity\Products;
use App\Service\CatalogService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CatalogController extends AbstractController
{
    /**
     * @Route("/catalog", name="app_catalog")
     */
    public function show(EntityManagerInterface $entityManager, PaginatorInterface $paginator, CatalogService $catalog, Request $request): Response
    {
        $products = $entityManager->getRepository(Products::class)->findAll();
        if (!$products) {
            throw $this->createNotFoundException('No product found for id ');
        }

        // $products = $catalog->products($em);

        // $price = $request->query->get('price');
        // $price2 = explode(";",$price);
        // if(isset($price)) {
        //     var_dump($price2);
        //     $seller = $request->query->get('seller');
        //     $title = $request->query->get('title');
        //     $model = $request->query->get('model');
        //     $products = $catalog->products2($repository,intval($price2[0]),intval($price2[1]),$seller,$title,$model);
        // }
        // $query = $request->query->get('qr');
        // if($query) {
        //     $products = $repository->searchByQuery($query);
        // }
        // $q = $request->query->get('q');

        // if ($q == 1) {
        //     $products = $catalog->products3($repository);

        // }

        $pagination = $paginator->paginate(
            $products,
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('catalog/catalog.html.twig', [
            'controller_name' => 'CatalogController',
            'pagination' => $pagination,
        ]);
    }
}
