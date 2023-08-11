<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Order;
use App\Entity\OrderProducts;
use App\Entity\Products;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
//        return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
         $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
         return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('ShopMEG');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),
            MenuItem::linktoRoute('Back to the website', 'fas fa-sign-out', 'app_index'),
            // MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class),
            MenuItem::section('Users'),
            MenuItem::linkToCrud('User', 'fas fa-user', User::class),

            MenuItem::section('Products'),
            MenuItem::linkToCrud('Category', 'fas fa-tags', Category::class),
            MenuItem::linkToCrud('Products', 'fas fa-product', Products::class),
            MenuItem::linkToCrud('Comments', 'fas fa-comments', Comment::class),
            MenuItem::linkToCrud('Questions', 'fas fa-question', Comment::class),

            MenuItem::section('Orders'),
            MenuItem::linkToCrud('Order', 'fas fa-shopping-cart', Order::class),
            MenuItem::linkToCrud('OrderProducts', 'fas fa-list', OrderProducts::class),

        ];

    }
}
