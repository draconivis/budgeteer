<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class TransactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ['label' => 'For what? '])
            ->add('value', MoneyType::class, ['label' => 'Value of this transaction: ', 'divisor' => 100])
            ->add('date', DateTimeType::class, ['label' => 'date and time of transaction: ', 'date_widget' => 'choice'])
            ->add('reimbursement', CheckboxType::class, ['label' => 'Is this a reimbursement?', 'required' => false])
            ->add('save', SubmitType::class)
        ;
    }
}
