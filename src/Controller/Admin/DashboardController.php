<?php

namespace App\Controller\Admin;

use App\Entity\Order;
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
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
       // return parent::index();
		$routeBuilder = $this->container->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(OrderCrudController::class)->generateUrl();
        return $this->redirect($url);

    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Shop');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
   		yield MenuItem::linktoRoute('Back to the website', 'fas fa-home', 'app_index');
		 yield MenuItem::linkToCrud('Order', 'fas fa-comments', Order::class);
         yield MenuItem::linkToCrud('Products', 'fas fa-comments', Products::class);
         yield MenuItem::linkToCrud('User', 'fas fa-comments', User::class);

    }
}
