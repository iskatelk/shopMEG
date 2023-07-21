<?php

namespace App\Controller;

use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompareController extends AbstractController
{
    /**
     * @Route("/compare", name="app_compare")
     */
    public function show(EntityManagerInterface $entityManager) : Response
    {
        $product = $entityManager->getRepository(Products::class)->find($id);
        if (!$product) {
            throw $this->createNotFoundException(
            'No product found for id '.$id
            );
        }
 
        return $this->render('compare/compare.html.twig', [
			'controller_name' => 'CompareController',
			// 'product' => $product,
        ]);   
    }

    /**
     * @Route("/compare/remove", name="app_compare_remove")
     */
    public function remove() : Response
    {

        return $this->redirectToRoute('app_compare');
    }

   /**
     * @Route("/compare/add", name="app_compare_add")
     */
    public function add() : Response
    {

        return $this->redirectToRoute('app_compare');
    }
}