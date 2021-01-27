<?php

namespace App\Controller\Admin;

use App\Entity\Reaction;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ReactionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reaction::class;
    }

    public function configureFields(string $pageName): iterable
    {
        // We're missing a hideOnEdit() method.
        $id = TextField::new('id');
        $dto = $id->getAsDto();
        $displayedOn = $dto->getDisplayedOn();
        $displayedOn->delete(Crud::PAGE_EDIT);
        $dto->setDisplayedOn($displayedOn);

        return [$id];
    }
}
