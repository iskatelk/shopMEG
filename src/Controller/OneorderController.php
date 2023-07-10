<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Order;
use App\Entity\OrderProducts;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class OneorderController extends AbstractController
{
    /**
     * @Route("/oneorder", name="app_oneorder")
     */
    public function index(Request $request, EntityManagerInterface $em)
    {
        $orderNumber = $request->query->get('order');
         var_dump($orderNumber);
        $repository = $em->getRepository(Order::class);
        $order = $repository->findOneBy(array
		      ('orderNumber' => intval($orderNumber))
         );
		
		$customer = $request->getSession()->get(
            Security::LAST_USERNAME
        );
		$repository2 = $em->getRepository(User::class);
        $orderCustomer = $repository2->findOneBy(array
		      ('email' => $customer)
         );
		         		 
        $repository3 = $em->getRepository(OrderProducts::class);
        $orderDetails = $repository3->findBy(array
		      ('orderNumber' => intval($orderNumber))
         );	
        		 
        return $this->render('oneorder/oneorder.html.twig', [
           // 'controller_name' => 'OneorderController',
		   'order' => $order,
		   'orderDetails' => $orderDetails,
		   'orderCustomer' => $orderCustomer,
        ]);
    }
}
