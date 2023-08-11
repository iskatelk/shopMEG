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
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class PaymentsomeoneController extends AbstractController
{
    public $goodsOrd = [];
    public $countsOrd = [];
    public $gidsOrd = [];
    public $totalOrd;
    public $orderNumber;
    public $newCustomer;

    /**
     * @Route("/paymentsomeone1", name="app_paymentsomeone1")
     */
    public function index(Request $request, EntityManagerInterface $em, ProductsRepository $repository, OrderRepository $repository2): Response
    {

        $customer = $request->getSession()->get(
            Security::LAST_USERNAME
        );
     //  dd($customer);
        if (isset($customer)) {
        $this->newCustomer = $em->getRepository(User::class)->findOneBy(['email' => $customer]);

     /*   if (isset($customer)) {
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
            $result = $query->execute();*/
      /*  } else if (!isset($customer) && isset($_POST['name'])) {

            $this->newCustomer = new User();
            $this->newCustomer
                ->setEmail($_POST['mail'])
                ->setRoles(["ROLE_USER"])
                ->setPassword($_POST['passwordReply'])
                ->setCustomer($_POST['name'])
                ->setCity($_POST['city'])
                ->setAddress($_POST['address'])
                ->setPhone($_POST['phone']);
//           dd($newCustomer);

            $em->persist($this->newCustomer);

//            $em->flush();

        }*/

            //  if (isset($_POST['name'])) {
            $this->session = new Session();
            if (!isset($this->session)) {
                $this->session->start();


                $this->goodsOrd = $this->session->get('cart');
                //  $this->countsOrd = $this->session->get('counts');
                $this->totalOrd = '177.99';
                // $created = new \DateTimeImmutable('now');
                $order = new Order();
                $order
                    ->setTotalPrice($this->totalOrd)
                    ->setTypePayment($_POST['pay'])
                    ->setTypeDelivery($_POST['delivery'])
                    ->setCreatedAt(new \DateTime('now'))
                    ->setOrderStatus('waitpay')
                    ->setUser($this->newCustomer);
//      dd($newCustomer, $order);
                $em->persist($order);

//            $em->flush();
                //   dd($this->newCustomer);
                if (isset($this->goodsOrd)) {
//                dd($newCustomer, $this->goodsOrd);
                    foreach ($this->goodsOrd as $key => $cnt_id) {
                        if ($cnt_id > 0) {
                            foreach ($repository->findSelectProduct(intval($key)) as $product) {
                                $orderProducts = new OrderProducts();
                                $orderProducts
                                    ->setPrice($product->getPrice())
                                    ->setTitle($product->getName())
                                    ->setSeller($product->getSeller())
                                    ->setModel('1 Gb')
                                    ->setQuantity($cnt_id)
                                    ->setProductId($key)
                                    ->setOrderRef($order);

                                $em->persist($orderProducts);
                            }
                            // $prc = $repository->getPriceItem($prd_id);
                            // if(isset($this->countsOrd)) {

                            // }
                        }

                    }
                    //    dd($order, $newCustomer, $this->goodsOrd, $orderProducts);
                    $em->flush();
                }
                    //   $this->totalOrd = $this->session->get('total');
                }
                // dd($_POST['pay']);
            }

        $ord = $repository2->getMaxId();
        $this->orderNumber = intval($ord[0][1]);
        return $this->render('paymentsomeone/paymentsomeone.html.twig', [
           // 'controller_name' => 'PaymentsomeoneController',
            'orderNumber' => $this->orderNumber,
            'totalOrd' => $this->totalOrd,
        ]);
    }
}
