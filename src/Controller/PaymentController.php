<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderProducts;
use App\Entity\User;
use App\Repository\OrderRepository;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class PaymentController extends AbstractController
{
    public int $orderNumber;

    #[Route("/payment", name: "app_payment")]
    public function index( Request $request, EntityManagerInterface $em, ProductsRepository $products, OrderRepository $orders): Response
    {
//        $orderNmb = $request->query->get('order');
        $total = $request->getSession()->get('total');
        $pay = $request->request->get('pay');
        $delivery = $request->request->get('delivery');
        $customer = $request->getSession()->get(
            Security::LAST_USERNAME
        );

//dd('app_payment', $customer, $total, $pay, $delivery);

        if (isset($customer)
            && isset($_POST['name'])
        ) {
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
            $query->execute();

        } else {

            $newCustomer = new User();
            $newCustomer
                ->setEmail($request->request->get('mail'))
                ->setPassword($request->request->get('passwordReply'))
                ->setRoles(["ROLE_USER"])
                ->setCustomer($request->request->get('name'))
                ->setCity($request->request->get('city'))
                ->setAddress($request->request->get('address'))
                ->setPhone($request->request->get('phone'));
//                dd($newCustomer);
            $em->persist($newCustomer);
            $em->flush();
       }

        $email = $request->request->get('mail');
        $this->$customer = $em->getRepository(User::class)->findOneBy(['email' => $email]);

//         dd($_POST['pay'], $total);
        $created = new \DateTime('now');
//        dd($this->getUser(), $this->$customer, $email);
        $order = new Order();
        $order
            ->setUser($this->$customer)
            ->setTotalPrice($total)
            ->setTypePayment($pay)
            ->setTypeDelivery($delivery)
            ->setOrderStatus('waiting_for_payment')
            ->setCreatedAt($created);
        $em->persist($order);
        $em->flush();

        $ord = $orders->getMaxId();
        $orderNumber = intval($ord[0][1]);

        if (isset($_POST['name'])) {

            $goodsOrd = $request->getSession()->get('cart');
            $order = $em->getRepository(Order::class)->find($orderNumber);

            if (isset($goodsOrd)) {
                foreach ($goodsOrd as $key => $cnt_id) {
                    if ($cnt_id > 0) {
                        foreach ($products->findSelectProduct(intval($key)) as $product) {
                            $orderProducts = new OrderProducts();
                            $orderProducts
                                ->setOrderRef($order)
                                ->setTitle($product->getName())
                                ->setPrice($product->getPrice())
                                ->setQuantity($cnt_id)
                                ->setSeller($product->getSeller())
                                ->setModel('8 Gb')
                                ->setProductId($key);
                            $em->persist($orderProducts);
                        }
                    }
                }
                $em->flush();
            }
        }
        # очистить сессию от данных по заказу
        $request->getSession()->remove('cart');
        $request->getSession()->remove('total');
        $request->getSession()->remove('items');

        return match ($pay) {
            'online' => $this->render('payment/online_payment.html.twig', [
                'orderNumber' => $orderNumber,
                'total' => $total,
            ]),
            'someone' => $this->render('payment/someone_payment.html.twig', [
                'orderNumber' => $orderNumber,
                'totalOrd' => $total,
            ]),
            default => throw $this->createNotFoundException(
                'No payment data found for '
            ),
        };
    }

     #[Route("/payment/progress", name: "app_payment_progress")]
    public function paymentProgress(EntityManagerInterface $em, Request $request): Response
    {
        $orderNumber = $request->request->get('ordnmb');
        $str = $request->request->get('numero1');
//        dd($str, $orderNumber);
        $part = substr($str, 8);
        $part2 = intval($part);

         $order = $em->getRepository(Order::class)->findOneBy(['id' => $orderNumber]);

         if (($part2 != 0) && ($part2 % 2 == 0)) {

                $order->setOrderStatus('paymentOk');

//              dd($order, $part, $part2);

            } else {
                $order->setOrderStatus('paymentErr');
        }
         $em->persist($order);
         $em->flush();

        return $this->render('payment/payment_progress.html.twig', [
            // 'controller_name' => 'PaymentprogressController',
            'orderNumber' => $orderNumber,
        ]);
    }
}

