<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use App\Entity\Reaction;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();

        return $this->redirect(
            $routeBuilder
                ->setController(EventCrudController::class)
                ->generateUrl()
        );
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()->setTitle($this->getParameter('app_title'));
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Event', 'fas fa-list', Event::class);
        yield MenuItem::linkToCrud('Reaction', 'fas fa-list', Reaction::class);
    }
}
