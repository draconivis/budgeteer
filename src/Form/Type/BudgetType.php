<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class BudgetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startingValue', MoneyType::class, ['divisor' => 100])
            ->add('startDate', DateType::class)
            ->add('endDate', DateType::class)
            ->add('save', SubmitType::class/* , ['attr' => ['hx-target' => "#content-{$options['data']->getId()}"]] */)
        ;
    }
}
