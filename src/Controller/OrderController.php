<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ProductsRepository;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    public $goodsOrd = [];
    public $countsOrd = [];
    public $gidsOrd = [];

    /**
     * @Route("/order", name="app_order")
     */
    public function index (Request $request, EntityManagerInterface $em, ProductsRepository $repository2)
    {
        $customer = $request->getSession()->get(
            Security::LAST_USERNAME
        );
        var_dump($customer);
         $request->getSession()->set('orderConfirm',true);
        $repository = $em->getRepository(User::class);
        $orderDetails = $repository->findOneBy(array('email'=>$customer));
       
        $this->session = new Session();
        if(!isset($this->session)) $this->session->start();
        $this->goodsOrd = $this->session->get('cart');

        if(isset($this->goodsOrd)) {
            foreach ($this->goodsOrd as $key=>$cnt_id) {
                if ($cnt_id > 0) {
                    $this->gidsOrd[] = $repository2->findSelectProduct(intval($key));
                    $this->countsOrd[] = $cnt_id;
                }
            }
        }

        return $this->render('order/order.html.twig', [
           // 'controller_name' => 'OrderController',
            'orderDetails' => $orderDetails,
            'gidsOrd' => $this->gidsOrd,
            'totalOrd' => $this->session->get('total'),
            'countsOrd' => $this->countsOrd
        ]);
    }
}
