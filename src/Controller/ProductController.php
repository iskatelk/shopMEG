<?php

namespace App\Controller;

use App\Repository\ProductsRepository;
use App\Repository\SellersProductsRepository;
use App\Repository\SellersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="app_product_show")
     */
    public function show(Request $request, ProductsRepository $repository, SellersProductsRepository $sprepository, SellersRepository $srepository)
    {
        $p = $request->query->get('p');
       // dd($p);
        $productDetails = $repository->findOneBy(array('product_id'=>$p));
        $sellernames = $sprepository->findBy(array('product_id'=>$p));
       // dd($sellers);
      /*  $sellernames = [];
        foreach($sellers as $seller) {
            $sellernames[] = $srepository->find($seller->getSellerId());
        }*/
      //  dd($names);
        return $this->render('product/product.html.twig', [
           // 'controller_name', 'ProductController'
            'productDetails' => $productDetails,
            'sellernames' => $sellernames,
        ]);
    }
}