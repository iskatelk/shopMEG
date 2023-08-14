<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderProducts;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class OneorderController extends AbstractController
{
    /**
     * @Route("/oneorder/{id}", name="app_oneorder")
     */
    public function index(int $id, Request $request, EntityManagerInterface $em): Response
    {
//        $orderNumber = $request->query->get('order');
//        var_dump($orderNumber);
        $customer = $request->getSession()->get(
            Security::LAST_USERNAME
        );
        $userRepository = $em->getRepository(User::class);
        $userDetails = $userRepository->findOneBy([
            'email' => $customer,
        ]);

        $orderRepository = $em->getRepository(Order::class);
        $order = $orderRepository->findOneBy([
            'user' => $userDetails,
            'id' => $id,
        ]);

        $orderProductsRepository = $em->getRepository(OrderProducts::class);
        $orderDetails = $orderProductsRepository->findBy([
            'orderRef' => $id,
        ]);
//        dump($id, $orderDetails, $order);
        return $this->render('account/one_order.html.twig', [
           'order' => $order,
           'orderDetails' => $orderDetails,
           'userDetails' => $userDetails,
        ]);
    }
}
