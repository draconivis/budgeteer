<?php

namespace App\Controller;

use App\Entity\Budget;
use App\Entity\Transaction;
use App\Form\Type\TransactionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

#[Route(path: '/transaction')]
class TransactionController extends AbstractController
{
    private Budget $budget;

    public function __construct(private readonly EntityManagerInterface $em)
    {
        /** @var ?Budget $budget */
        $budget = $em->getRepository(Budget::class)->find(1);

        if (null === $budget) {
            throw new NotFoundResourceException('Budget is missing!');
        }

        $this->budget = $budget;
    }

    #[Route(path: '/new', methods: ['GET', 'POST'], priority: 10)]
    public function new(Request $request): Response
    {
        $transaction = new Transaction();
        $transaction->setDate(new \DateTime());

        $form = $this->createForm(TransactionType::class, $transaction);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $transaction->setBudget($this->budget);

            if ($transaction->isReimbursement()) {
                $this->budget->setCurrentValue(
                    $this->budget->getCurrentValue() + $transaction->getValue()
                );
            } else {
                $this->budget->setCurrentValue(
                    $this->budget->getCurrentValue() - $transaction->getValue()
                );
            }

            $this->em->persist($transaction);
            $this->em->flush();

            return $this->redirectToRoute('app_budget_dashboard');
        }

        return $this->render('transaction/new.html.twig', ['form' => $form]);
    }

    #[Route(path: '/edit/{id}', methods: ['GET', 'PATCH'], priority: 10)]
    public function edit(Request $request, int $id): Response
    {
        $transaction = $this->em->getRepository(Transaction::class)->findOneBy(['id' => $id, 'deleted' => false]);
        if (!$transaction instanceof Transaction) {
            throw new NotFoundHttpException("Transaction with id '{$id}' not found!");
        }

        $oldTransaction = clone $transaction;

        $form = $this->createForm(
            TransactionType::class,
            $transaction,
            ['action' => $this->generateUrl('app_transaction_edit', ['id' => $transaction->getId()])]
        );

        if ($request->isMethod('PATCH')) {
            $form->submit($request->getPayload()->all($form->getName()), false);

            if ($form->isSubmitted() && $form->isValid()) {
                // first undo the previous calculations
                // notice the reversed logic here
                if ($oldTransaction->isReimbursement()) {
                    $this->budget->setCurrentValue(
                        $this->budget->getCurrentValue() - $oldTransaction->getValue()
                    );
                } else {
                    $this->budget->setCurrentValue(
                        $this->budget->getCurrentValue() + $oldTransaction->getValue()
                    );
                }

                // now apply the new values
                if ($transaction->isReimbursement()) {
                    $this->budget->setCurrentValue(
                        $this->budget->getCurrentValue() + $transaction->getValue()
                    );
                } else {
                    $this->budget->setCurrentValue(
                        $this->budget->getCurrentValue() - $transaction->getValue()
                    );
                }

                $this->em->flush();

                return $this->render('transaction/transactionWithUpdate.html.twig', ['transaction' => $transaction, 'budget' => $this->budget]);
            }
        }

        return $this->render('transaction/edit.html.twig', ['transaction' => $transaction, 'form' => $form]);
    }

    #[Route(path: '/delete/{id}', methods: 'DELETE', priority: 10)]
    public function delete(Request $request, int $id): Response
    {
        $transaction = $this->em->getRepository(Transaction::class)->findOneBy(['id' => $id, 'deleted' => false]);
        if (!$transaction instanceof Transaction) {
            throw new NotFoundHttpException("Transaction with id '{$id}' not found!");
        }

        // undo the changes this transaction caused
        if ($transaction->isReimbursement()) {
            $this->budget->setCurrentValue(
                $this->budget->getCurrentValue() - $transaction->getValue()
            );
        } else {
            $this->budget->setCurrentValue(
                $this->budget->getCurrentValue() + $transaction->getValue()
            );
        }

        $transaction->setDeleted(true);

        $this->em->flush();

        return $this->render('budget/budgteValueUpdate.html.twig', ['budget' => $this->budget]);
    }
}
