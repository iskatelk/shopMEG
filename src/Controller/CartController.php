<?php

namespace App\Controller;

use App\Service\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class CartController extends AbstractController
{
/*	 private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }*/

	 /**
     * @Route("/cart", name = "app_cart")
     */
    public function index(CartService $cart)
    {
			// dd($cart->getFull());
			 return $this->render('cart/cart.html.twig', [
            //'goods' => $cart->getFull(),
            'goods' => $cart->getFull(),
        ]);
    }

     /**
     * @Route("/cart/add/{id}", name="app_cart_add")
     */
    public function add(CartService $cart, $id)
    {
        $cart->add($id);
        return $this->redirectToRoute('app_cart');
    }

    /**
     * @Route("/cart/remove", name="remove_to_cart")
     */
    public function remove(CartService $cart)
    {
        $cart->remove();
        return $this->redirectToRoute('app_cart');
    }

	/**
     * @Route("/cart/delete/{id}", name="app_cart_delete")
     */
    public function delete(CartService $cart, $id)
    {
 
        $cart->delete($id);
        return $this->redirectToRoute('app_cart');
    }
 
    /**
     * @Route("/cart/decrease/{id}", name="decrease_to_cart")
     */
    public function decrease(CartService $cart, $id)
    {
        $cart->decrease($id);
        return $this->redirectToRoute('app_cart');
    }
	
	/**
     * @Route("/cart/increase/{id}", name="increase_to_cart")
     */
    public function increase(CartService $cart, $id)
    {
        $cart->increase($id);
        return $this->redirectToRoute('app_cart');
    }
}