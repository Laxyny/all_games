<?php

namespace App\Controller\Admin;

use App\Entity\Editor;
use App\Entity\Game;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('All Games');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-newspaper');
        yield MenuItem::linkToCrud('Editor', 'fas fa-list', Editor::class);
        yield MenuItem::linkToCrud('Game', 'fas fa-list', Game::class);
        yield MenuItem::linkToCrud('genre', 'fas fa-gamepad', 'App\Entity\Genre');
        yield MenuItem::linkToCrud('User', 'fas fa-users', 'App\Entity\User');
        yield MenuItem::linkToLogout('Logout', 'fa fa-sign-out-alt');
        yield MenuItem::section('Settings');
        yield MenuItem::linkToRoute('Back to site', 'fa fa-home', 'app_home');
    }
}
