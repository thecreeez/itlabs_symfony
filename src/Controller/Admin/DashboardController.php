<?php

namespace App\Controller\Admin;

use App\Entity\Guest;
use App\Entity\Table;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Административная панель');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToCrud('Гости', 'fas fa-list', Guest::class)
                ->setController(GuestCrudController::class),

            MenuItem::linkToCrud('Столы', 'fas fa-list', Table::class)
                ->setController(TableCrudController::class),
        ];
        //yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        //yield MenuItem::linkToCrud('Гости', 'fas fa-list', GuestCrudController::class);
    }
}
