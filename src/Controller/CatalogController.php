<?php

namespace App\Controller;

use App\Entity\Products;
use App\Repository\ProductsRepository;
use App\Service\CatalogService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CatalogController extends AbstractController {

    /**
     * @Route("/catalog", name="app_catalog")
     */
    public function show(Request $request, EntityManagerInterface $em,PaginatorInterface $paginator, ProductsRepository $repository, CatalogService $catalog)
    {
        
		$comments = $catalog->comments($em);

        $price = $request->query->get('price');
        $price2 = explode(";",$price);
        if(isset($price)) {
            var_dump($price2);
            $seller = $request->query->get('seller');
            $title = $request->query->get('title');
            $model = $request->query->get('model');
            $comments = $catalog->comments2($repository,intval($price2[0]),intval($price2[1]),$seller,$title,$model);
        }
        $query = $request->query->get('qr');
        if($query) {
            $comments = $repository->searchByQuery($query);
        }
        $q = $request->query->get('q');

        if ($q == 1) {
            $comments = $catalog->comments3($repository);

        }

        $pagination = $paginator->paginate(

        $comments ,
        $request->query->getInt('page', 1),
            3
        );

        return $this->render('catalog/catalog.html.twig', [
            //'article' => ucwords(str_replace('-', ' ', $slug)),
            'pagination' => $pagination,
        ]);
    }

}