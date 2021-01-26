<?php

namespace App\Controller\Admin;

use App\Entity\Reaction;
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
        return [TextField::new('id')];
    }
}
