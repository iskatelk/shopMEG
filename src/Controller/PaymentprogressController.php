<?php

namespace App\Controller;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentprogressController extends AbstractController
{
    /**
     * @Route("/paymentprogress", name="app_paymentprogress")
     */
    public function index(EntityManagerInterface $em)
    {
        $orderNumber = $_POST['ordnmb'];
        $str = $_POST['numero1'];
        $part = substr($str,8);
        $part2 = intval($part);
        if(($part2 != 0) && ($part2%2 == 0)){

            $em->getConnection()
                ->executeStatement("UPDATE `order` SET order_status = ? WHERE order_number = ? ", [
        'paymentOK',
        $orderNumber]);
            } else {

            $em->getConnection()
                ->executeStatement("UPDATE `order` SET order_status = ? WHERE order_number = ? ", [
                    'paymentErr',
                    $orderNumber]);
        }
        var_dump($_POST['numero1']);

        return $this->render('paymentprogress/paymentprogress.html.twig', [
            //'controller_name' => 'PaymentprogressController',
            'orderNumber' => $orderNumber,
        ]);
    }
}
