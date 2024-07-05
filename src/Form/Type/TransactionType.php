<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Routing\RouterInterface;

class TransactionType extends AbstractType
{
    public function __construct(
        private RouterInterface $router
    ) {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // dd($options);
        $transactionId = $options['data']->getId();
        $getRoute = $this->router->generate('app_transaction_get', ['id' => $transactionId]);

        $builder
            ->add('title', TextType::class, ['label' => 'For what?'])
            ->add('value', MoneyType::class, ['label' => 'Value of this transaction:', 'divisor' => 100, 'currency' => false]) // set currency to false so the euro sign isn't shown on the left
            ->add('date', DateTimeType::class, ['label' => 'date and time of transaction:'/* , 'date_widget' => 'choice' */])
            ->add('reimbursement', CheckboxType::class, ['label' => 'Is this a reimbursement?', 'required' => false])
            ->add('save', SubmitType::class)
            ->add(
                'cancel',
                ButtonType::class,
                [
                    'attr' => [
                        'hx-target' => "#transaction-{$transactionId}",
                        'hx-swap' => 'outerHTML',
                        'hx-get' => $getRoute,
                    ],
                ]
            )
        ;
    }
}
