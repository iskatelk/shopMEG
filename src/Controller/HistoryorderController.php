<?php

namespace App\Controller;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class HistoryorderController extends AbstractController
{
    /**
     * @Route("/historyorder", name="app_historyorder")
     */
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $customer = $request->getSession()->get(
            Security::LAST_USERNAME
        );
        $repository = $em->getRepository(Order::class);
        $orders = $repository->findBy(
            ['email' => $customer],
            ['orderNumber' => 'DESC']
        );

        return $this->render('historyorder/historyorder.html.twig', [
           // 'controller_name' => 'HistoryorderController',
           'orders' => $orders,
        ]);
    }
}
