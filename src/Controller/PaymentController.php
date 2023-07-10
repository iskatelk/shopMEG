<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Order;
use App\Entity\OrderProducts;
use App\Repository\OrderRepository;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class PaymentController extends AbstractController
{
    public $goodsOrd = [];
    public $countsOrd = [];
    public $gidsOrd = [];
    public $totalOrd;
    public $orderNumber;
    /**
     * @Route("/payment", name="app_payment")
     */
    public function index(Request $request, EntityManagerInterface $em, ProductsRepository $repository,  OrderRepository $repository2)
    {
		$orderNmb = $request->query->get('order');
        $customer = $request->getSession()->get(
            Security::LAST_USERNAME
        );
       
		
		if(isset($orderNmb)){ 
		 var_dump($orderNmb);
		 $this->orderNumber = $orderNmb;
		} else {

        $ord = $repository2->getMaxId();
        $this->orderNumber = intval($ord[0][1]) + 1;

            if(isset($customer)) {

                $queryBuilder = $em->createQueryBuilder();
                $query = $queryBuilder->update('App:User', 'u')
                    ->set('u.customer', ':userName')
                    ->set('u.city', ':city')
                    ->set('u.address', ':address')
                    ->where('u.email = :email')
                    ->setParameter('userName', $_POST['name'])
                    ->setParameter('city', $_POST['city'])
                    ->setParameter('address', $_POST['address'])
                    ->setParameter('email', $_POST['mail'])
                    ->getQuery();
                $result = $query->execute();
            }

        //  dd($this->orderNumber);
        if(!isset($customer) && isset($_POST['name'])) {

            $newCustomer = new User();
            $newCustomer
                ->setEmail($_POST['mail'])
                ->setPassword($_POST['passwordReply'])
                ->setCustomer($_POST['name'])
                ->setCity($_POST['city'])
                ->setAddress($_POST['address'])
                ->setPhone($_POST['phone']);

            $em->persist($newCustomer);
            $em->flush();
        }

        if(isset($_POST['name'])){
            $this->session = new Session();
            if(!isset($this->session)) $this->session->start();

            $this->goodsOrd = $this->session->get('goods');
            $this->countsOrd = $this->session->get('counts');



            if(isset($this->goodsOrd)) {
                foreach ($this->goodsOrd as $key => $prd_id) {

                    if ($prd_id > 0) {

                           foreach($repository->findSelectProduct(intval($prd_id)) as $product) {

                               $orderProducts = new OrderProducts();
                               $orderProducts
                                   ->setPrice($product->getPrice())
                                   ->setTitle($product->getTitle())
                                   ->setSeller($product->getSeller())
                                   ->setModel($product->getModel())
                                   ->setQuantity($this->countsOrd[$key])
                                   ->setProductId($prd_id)
                                   ->setOrderNumber($this->orderNumber);

                                    $em->persist($orderProducts);
                                    $em->flush();

                           }
                        $prc = $repository->getPriceItem($prd_id);
                        if(isset($this->countsOrd)) {
                            $this->totalOrd += $prc[0]['price'] * $this->countsOrd[$key];
                        }
                    }

                }
            }
            // dd($_POST['pay']);
            $created = new \DateTimeImmutable('now');
                 $order = new Order();
                  $order
                      ->setOrderNumber($this->orderNumber)
                      ->setTotalPrice($this->totalOrd)
                      ->setTypePayment($_POST['pay'])
                      ->setTypeDelivery($_POST['delivery'])
                      ->setOrderStatus('waitpay')
                      ->setCustomerName($_POST['name'])
					  ->setEmail($_POST['mail'])
                      ->setCreatedAt($created);
                  $em->persist($order);
                  $em->flush();
        }
		}
        return $this->render('payment/payment.html.twig', [
           // 'controller_name' => 'PaymentController',
            'orderNumber' => $this->orderNumber,
            'totalOrd' => $this->totalOrd,
        ]);
    }
}
