<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use Doctrine\ORM\Mapping\Id;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
//use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
           // Field::new('id'),
            TextField::new('name'),
            TextField::new('parent', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name'] ),

//            ChoiceField::new('Id' . ' ' . 'name'),
            /*           ChoiceField::new('parent')->setChoices([
                           'Paid Invoice' => 'paid',
                           'Invoice Sent but Unpaid' => 'pending',
                           'Refunded Invoice' => 'refunded',
                       ]),
           */
            /*
                        ChoiceField::new('...')->setChoices(
                            static fn (?Category $foo): array => $foo->IdField()->getChoices()
                        ),
            */
//            ChoiceField::new('parent')->autocomplete(),
//            ChoiceField::new('parent')->allowMultipleChoices(),
//            TextEditorField::new('description'),
        ];
    }

}
