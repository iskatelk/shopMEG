<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class OrderController extends AbstractController
{
    public $goodsOrd = [];
    public $countsOrd = [];
    public $gidsOrd = [];

    /**
     * @Route("/order", name="app_order")
     */
    public function index(Request $request, EntityManagerInterface $em, ProductsRepository $products): Response
    {
//        dd($request->request->all());

        $customer = $request->getSession()->get(
            Security::LAST_USERNAME
        );
//        $amount = $request->request->get('amount');
//        dd($amount);
        $request->getSession()->set('orderConfirm', true);
        $goodsOrd = $request->getSession()->get('cart');
        $total = $request->getSession()->get('total');

        $user = $em->getRepository(User::class);
        $orderDetails = $user->findOneBy(['email' => $customer]);

//        dd($customer, $user, $orderDetails);

        if (isset($goodsOrd)) {
            foreach ($this->goodsOrd as $key => $cnt_id) {
                if ($cnt_id > 0) {
                    $this->gidsOrd[] = $products->findSelectProduct(intval($key));
                    $this->countsOrd[] = $cnt_id;
                }
            }
        }
//    dd($this->gidsOrd);

        return $this->render('order/order.html.twig', [
           // 'controller_name' => 'OrderController',
            'orderDetails' => $orderDetails,
            'sale' => '10',
            'gidsOrd' => $this->gidsOrd,
            'totalOrd' => $total,
            'countsOrd' => $this->countsOrd,
        ]);
    }
}
