<?php

namespace App\Controller;

use App\Repository\SellersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{
    /**
     * @Route("/shop", name="app_shop")
     */
    public function shop(Request $request, SellersRepository $repository):Response
    {
        $id = $request->query->get('id');
        //$id = 1;
        $seller = $repository->find($id);

        return $this->render('shop/shop.html.twig', [
            //'controller_name', 'ShopController',
            'seller' => $seller,
        ]);
    }
}