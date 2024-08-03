<?php

namespace App\Form\Type;

use App\Entity\Transaction;
use Symfony\Component\Config\Definition\Exception\Exception;
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
        private readonly RouterInterface $router
    ) {}

    #[\Override]
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $transaction = $options['data'];
        if (!$transaction instanceof Transaction) {
            throw new Exception('No Transaction passed to Form!');
        }

        /** @var int $transactionId */
        $transactionId = $transaction->getId();

        $builder
            ->add('title', TextType::class, ['label' => 'For what?'])
            ->add('value', MoneyType::class, ['label' => 'Value of this transaction:', 'divisor' => 100, 'currency' => false]) // set currency to false so the euro sign isn't shown on the left
            ->add('date', DateTimeType::class, ['label' => 'date and time of transaction:'/* , 'date_widget' => 'choice' */])
            ->add('reimbursement', CheckboxType::class, ['label' => 'Is this a reimbursement?', 'required' => false])
            ->add('save', SubmitType::class)
        ;

        if (0 === $transactionId) {
            $builder->add(
                'cancel',
                ButtonType::class,
                [
                    'attr' => [
                        'hx-target' => '#add-transaction',
                        'hx-swap' => 'innerHTML',
                        'hx-get' => $this->router->generate('app_budget_addtransactionbutton'),
                    ],
                ]
            );
        } else {
            $builder->add(
                'cancel',
                ButtonType::class,
                [
                    'attr' => [
                        'hx-target' => '#transaction-'.$transactionId,
                        'hx-swap' => 'outerHTML',
                        'hx-get' => $this->router->generate('app_transaction_get', ['id' => $transactionId]),
                    ],
                ]
            );
        }
    }
}
