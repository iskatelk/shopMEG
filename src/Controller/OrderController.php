<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Products;
use App\Repository\ProductsRepository;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    public $goodsOrd = [];
    public $countsOrd = [];
    public $gidsOrd = [];
    public $totalOrd;

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
       // var_dump($orderDetails);
       // var_dump($_COOKIE);

        $this->session = new Session();
        if(!isset($this->session)) $this->session->start();

        $this->goodsOrd = $this->session->get('goods');
        $this->countsOrd = $this->session->get('counts');

        if(isset($this->goodsOrd)) {
            foreach ($this->goodsOrd as $key => $prd_id) {
                //  dd($prd_id);
                if ($prd_id > 0) {
                    $this->gidsOrd[] = $repository2->findSelectProduct(intval($prd_id));


                    $prc = $repository2->getPriceItem($prd_id);
                    if(isset($this->countsOrd)) {
                        $this->totalOrd += $prc[0]['price'] * $this->countsOrd[$key];
                    }
                }

            }
        }

        return $this->render('order/order.html.twig', [
           // 'controller_name' => 'OrderController',
            'orderDetails' => $orderDetails,
            'gidsOrd' => $this->gidsOrd,
            'totalOrd' => $this->totalOrd,
            'countsOrd' => $this->countsOrd

        ]);

    }
}
