<?php

namespace App\Controller\Admin;

use App\Entity\Table;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TableCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Table::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideWhenCreating()->hideWhenUpdating(),
            NumberField::new('number', 'Номер стола'),
            TextField::new('description', 'Описание'),
            NumberField::new('maxGuests', 'Макс количество человек'),
            NumberField::new('getGuestsDef', 'Гостей')->hideWhenCreating()->hideWhenUpdating(),
            NumberField::new('getGuestsNow', 'Присутствует гостей')->hideWhenCreating()->hideWhenUpdating(),
        ];
    }
}
