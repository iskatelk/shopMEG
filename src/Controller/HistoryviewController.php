<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HistoryviewController extends AbstractController
{
    /**
     * @Route("/historyview", name="app_historyview")
     */
    public function index(): Response
    {
        return $this->render('historyview/historyview.html.twig', [
            'controller_name' => 'HistoryviewController',
        ]);
    }
}
