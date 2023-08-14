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

     #[Route("/account", name: "app_account")]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $customer = $request->getSession()->get(
            Security::LAST_USERNAME
        );

        //        $request->getSession()->set('checkLogin',true); // 2023/07/07
//        $request->getSession()->set('customer', $customer); // 2023/07/07
        $repository = $em->getRepository(User::class); // 2023/07/07
        $userDetails = $repository->findOneBy(
            ['email' => $customer]
        );
//        dd($userDetails);

        $repository = $em->getRepository(Order::class);
        $orderDetails = $repository->findOneBy(
            ['user' => $userDetails],
            ['id' => 'DESC']
        );
        // dd($orderDetails);
        return $this->render('account/account.html.twig', [
           // 'controller_name' => 'AccountController',
           'orderDetails' => $orderDetails,
           'userDetails' => $userDetails,
        ]);
    }

     #[Route("/history_order", name: "app_history_order")]
    public function historyOrder(Request $request, EntityManagerInterface $em): Response
    {
        $customer = $request->getSession()->get(
            Security::LAST_USERNAME
        );
        $user = $em->getRepository(User::class)->findOneBy(['email' => $customer]);
//        dd($user);
        $repository = $em->getRepository(Order::class);
        $orders = $repository->findBy(
            ['user' => $user],
            ['id' => 'DESC']
        );

        return $this->render('account/history_order.html.twig', [
            'orders' => $orders,
        ]);
    }


     #[Route("/profile", name: "app_profile")]
    public function profile(Request $request, EntityManagerInterface $em): Response
    {
        $customer = $request->getSession()->get(
            Security::LAST_USERNAME
        );
        $repository = $em->getRepository(User::class);
        $userDetails = $repository->findOneBy(['email' => $customer]);
        if (!isset($result)) {
            $result = null;
        }

        if ($request->isMethod('POST')) {
            $userDetails
                ->setEmail($request->request->get('mail'))
                ->setPhone($request->request->get('phone'))
                ->setPassword($request->request->get('password'))
                ->setRoles(['ROLE_USER'])
                ->setCustomer($request->request->get('name'))
                ->setCity('city')
                ->setAddress('address');

            $em->flush();
            $result = 'success';
        }

        $repository = $em->getRepository(User::class);
        $userDetails = $repository->findOneBy(['email' => $customer]);

        return $this->render('account/profile.html.twig', [
            // 'controller_name' => 'ProfileController',
            'userDetails' => $userDetails,
            'success' => $result,
        ]);
    }
}
