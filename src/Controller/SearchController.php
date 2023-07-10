<?php

namespace App\Controller;

use App\Repository\ProductsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="app_search")
     */
    public function search(Request $request, ProductsRepository $repository): Response
    {
        $query = $request->query->get('qr');
        var_dump($query);
        $posts = $repository->searchByQuery($query);
        var_dump($posts);
        return $this->render('search/search.html.twig', [
            'posts' => $posts
        ]);
    }
}
