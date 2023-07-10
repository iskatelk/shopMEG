<?php

namespace App\Controller;

use App\Entity\Products;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class CartController extends AbstractController
{
    public $session;
    public $goods=[];
    public $gids=[];
    public $counts;
    public $combine;
    public $cart=[];
    public $items;
    public $total;
    public $product_id;
    public $total_price;
	public $totalcnt;
	
   public function __construct() {
       $this->session = new Session();
    }

    /**
     * @Route("/cart", name = "app_cart")
     * @Method("POST")
     */
    public function show(ProductsRepository $repository): Response
    {
        $this->goods = $this->session->get('goods');
        $this->counts = $this->session->get('counts');

        if (isset($this->goods)) {
            foreach ($this->goods as $key => $prd_id) {
                if ($prd_id > 0) {
                    $this->gids[] = $repository->findSelectProduct(intval($prd_id));

                    $prc = $repository->getPriceItem($prd_id);
                    if (isset($this->counts)) {
                        $this->total += $prc[0]['price'] * $this->counts[$key];
                        $this->totalcnt += $this->counts[$key];
                        $this->session->set('total', $this->total);
                        $this->session->set('totalcnt', $this->totalcnt);
                    }
                }
            }
        }

        return $this->render('cart/cart.html.twig', [
            'goods' => $this->goods,
            'gids' => $this->gids,
            'counts' => $this->counts,
            'total' => $this->total
        ]);
    }

    /**
     * @Route("/cart/delete", name="app_cart_delete")
     */
    public function delete(Request $request): Response
    {
        $d = $request->query->get('d');
        $this->product_id = $d;
        $this->counts = $this->session->get('counts');
        $this->goods = $this->session->get('goods');

        $i = 0;
        while ($this->goods[$i] != $this->product_id && $i < count($this->goods)) $i++;
        // $this->goods[0] = 0;
        $this->counts[$i] = 0;
        $this->session->set('goods', $this->goods);
        $this->session->set('counts', $this->counts);

        return $this->redirectToRoute('app_cart');
    }

    /**
     * @Route("/cart/add", name="app_cart_add")
     */

    public function add(Request $request, ProductsRepository $repository): Response
    {
        $p = $request->query->get('p');
        if ($p > 0) {
            $this->product_id = $p;

            $this->goods = $this->session->get('goods');
            $this->counts = $this->session->get('counts');
            $i = 0;
            if (isset($this->goods)) $cnt = count($this->goods);
            else $cnt = 1;
            if (isset($this->goods)) {
                foreach ($this->goods as $item) {
                    if ($item == $this->product_id) {
                        $this->counts[$i]++;
                        break;
                    } else if ($i + 1 == $cnt) {
                        $this->goods[$i + 1] = $this->product_id;
                        $this->counts[$i + 1] = 1;
                    }
                    $i++;
                }
            } else {
                $this->goods[0] = $this->product_id;
                $this->counts[0] = 1;
            }
            $this->session->set('goods', $this->goods);
            $this->session->set('counts', $this->counts);

        }
        return $this->redirectToRoute('app_cart');
    }

    /**
     * @Route("/cart/update", name="app_cart_update")
     */

    public function update(): Response
    {
        if (isset($_POST['clear'])) {
            $this->session->remove('goods');
            $this->session->remove('counts');
        }

        if (isset($_POST['update'])) {
            $this->counts = $this->session->get('counts');
            $this->goods = $this->session->get('goods');

            foreach ($_POST['amount'] as $item_id => $count_item) {

                for ($i = 0; $i < count($this->goods); $i++)
                    if ($this->goods[$i] == intval($item_id)) {
                        $this->counts[$i] = intval($count_item);
                    }
            }
            $this->session->set('counts', $this->counts);
        }
        return $this->redirectToRoute('app_cart');
    }
}