<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class AccountController extends AbstractController
{
    /**
     * @Route("/account", name="app_account")
     */
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $customer = $request->getSession()->get(
            Security::LAST_USERNAME
        );
        //        $request->getSession()->set('checkLogin',true); // 2023/07/07
        $request->getSession()->set('customer', $customer); // 2023/07/07
        $repository = $em->getRepository(User::class); // 2023/07/07
        $userDetails = $repository->findOneBy(
            ['email' => $customer]
        );

        $repository = $em->getRepository(Order::class);
        $orderDetails = $repository->findOneBy(
            ['email' => $customer],
            ['orderNumber' => 'DESC']
        );
        // dd($orderDetails);
        return $this->render('account/account.html.twig', [
           // 'controller_name' => 'AccountController',
           'orderDetails' => $orderDetails,
           'userDetails' => $userDetails,
        ]);
    }
}
