<?php

namespace App\Controller;

use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
    public function index(CartService $cart, Request $request): Response
    {
        $cart->setTotal();
        $goods = $cart->getFull();
        $total = $request->get('total');
//        dd($total);
        return $this->render('cart/cart.html.twig', [
            'goods' => $goods,
            'total' => $total,
        ]);
    }

    /**
     * @Route("/cart/add/{id}", name="app_cart_add")
     */
    public function add(Request $request, CartService $cart, $id): RedirectResponse
    {
        if ($request->isMethod('POST')
        && $amount = $request->request->get('amount')
        ) {
//        $amount = $request->query->get('amount');
        $cart->add($id, $amount);
        } else {
            $cart->add($id, 1);
        }

        return $this->redirectToRoute('app_cart');
    }

    /**
     * @Route("/cart/remove", name="remove_to_cart")
     */
    public function remove(CartService $cart): RedirectResponse
    {
        $cart->remove();

        return $this->redirectToRoute('app_cart');
    }

    /**
     * @Route("/cart/delete/{id}", name="app_cart_delete")
     */
    public function delete(CartService $cart, $id): RedirectResponse
    {
        $cart->delete($id);

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/confirm', name: 'app_cart_confirm')]
    public function cartConfirm(CartService $cart, Request $request): RedirectResponse
    {
//                dd($request->request->all());
        if ($request->isMethod('POST')
            && $amounts = $request->request->get('amount')
        ) {
            foreach ($amounts as $key => $amount) {
                $cart->add($key, $amount);
            }
        }

        return $this->redirectToRoute('app_order');
    }

    #[Route('/cart/update', name: 'app_cart_update')]
    public function cartUpdate(CartService $cart, Request $request): RedirectResponse
    {
//        dd($request->request->all());
        if ($request->isMethod('POST')
            && $amounts = $request->request->get('amount')
        ) {
            foreach ($amounts as $key => $amount) {
                $cart->add($key, $amount);
            }
        }

        return $this->redirectToRoute('app_cart');
    }

    /**
     * @Route("/cart/decrease/{id}", name="decrease_to_cart")
     */
    public function decrease(CartService $cart, $id): RedirectResponse
    {
        $cart->decrease($id);

        return $this->redirectToRoute('app_cart');
    }

    /**
     * @Route("/cart/increase/{id}", name="increase_to_cart")
     */
    public function increase(CartService $cart, $id): RedirectResponse
    {
        $cart->increase($id);

        return $this->redirectToRoute('app_cart');
    }
}
