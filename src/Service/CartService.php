<?php

namespace App\Service;

use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager, private SessionInterface $session)
    {
        $this->entityManager = $entityManager;
    }

    public function add($id, $quantity): void
    {
//        $requestStack->getSession()->get('cart')
        $cart = $this->get();
        $cart[$id] = $quantity;
        $this->session->set('cart', $cart);
        $this->setTotal();
    }

    public function get()
    {
        return $this->session->get('cart', []);
    }

    public function setTotal()
    {
        $goods = $this->getFull();
        $total = 0;
        $i = 0;
        foreach ($goods as $good) {
            $total += $good['subTotal'];
            $i++;
        }

        $this->session->set('items', $i);
        $this->session->set('total', $total);
        return $total;
    }

    public function getQuantity($id): int|null
    {
        $cart = $this->session->get('cart', []);
        return $cart[$id] ?? null;
    }

    public function remove(): void
    {
        $this->session->remove('cart');
        $this->setTotal();
    }

    public function delete($id): void
    {
        $cart = $this->session->get('cart', []);
        unset($cart[$id]);
        $this->session->set('cart', $cart);
        $this->setTotal();
    }
/*
    public function decrease($id)
    {
        $cart = $this->session->get('cart', []);
        if ($cart[$id] > 1) {
            --$cart[$id];
        } else {
            //            unset($cart[$id]);
        }

        return $this->session->set('cart', $cart);
    }

    public function increase($id)
    {
        $cart = $this->session->get('cart', []);
        if ($cart[$id] > 0) {
            ++$cart[$id];
        } else {
            unset($cart[$id]);
        }

        return $this->session->set('cart', $cart);
    }
*/
    public function getFull(): array
    {
        $cartComplete = [];
        $cart = $this->get();
        if ($cart) {
            foreach ($cart as $id => $quantity) {
                $product_object = $this->entityManager->getRepository(Products::class)->find($id);
                if (!$product_object) {
                    $this->delete($id);
                    continue;
                }
                $cartComplete[] = [
                    'product' => $product_object,
                    'quantity' => $quantity,
                    'subTotal' => $quantity * $product_object->getPrice(),
                    'price' => $product_object->getPrice(),
                ];
            }
        }

        return $cartComplete;
    }
}
