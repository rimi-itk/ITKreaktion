<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class EventCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Event::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        $share = Action::new('Share')
            ->linkToCrudAction('shareEvent', fn (Event $event) => ['id' => $event->getId()]);
        $present = Action::new('Present')
            ->linkToCrudAction('presentEvent', fn (Event $event) => ['id' => $event->getId()]);

        return $actions
            ->disable(Action::DELETE)
            ->add(Crud::PAGE_INDEX, $present)
            ->add(Crud::PAGE_INDEX, $share);
    }

    public function shareEvent(AdminContext $context): Response
    {
        $event = $context->getEntity()->getInstance();

        return $this->redirectToRoute('event_share', ['id' => $event->getId()]);
    }

    public function presentEvent(AdminContext $context): Response
    {
        $event = $context->getEntity()->getInstance();

        return $this->redirectToRoute('event_present', ['id' => $event->getId(), 'code' => $event->getCode()]);
    }
}
