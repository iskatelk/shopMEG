<?php

namespace App\Controller;

use App\Entity\HistoryView;
use App\Entity\Products;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


class HistoryviewController extends AbstractController
{
     #[Route("/history_view", name: "app_history_view")]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
        $customer = $request->getSession()->get(
            Security::LAST_USERNAME
        );
        $userDetails = $entityManager->getRepository(User::class)->findOneBy(['email' => $customer]);

        $productDetail = $entityManager->getRepository(Products::class)->findAll();

//        dd('HistoryView', $userDetails);

        $views = $entityManager->getRepository(HistoryView::class)->findBy([
            'product' => $productDetail,
            'user' => $userDetails,
        ]);

//        dd($userDetails, $views);

        return $this->render('account/history_view.html.twig', [
            'views' => $views,
        ]);
    }
}
