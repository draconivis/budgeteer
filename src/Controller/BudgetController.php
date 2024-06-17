<?php

namespace App\Controller;

use App\Entity\Budget;
use App\Form\Type\BudgetType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/budget')]
class BudgetController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $em) {}

    #[Route(path: '')]
    #[Route(path: '/')]
    public function index(): Response
    {
        return $this->redirectToRoute('app_budget_dashboard');
    }

    #[Route(path: '/dash', methods: 'GET')]
    public function dashboard(): Response
    {
        /** @var Budget[] $budgets */
        $budgets = $this->em->createQueryBuilder()
            ->select('b')
            ->from(Budget::class, 'b')
            ->leftJoin('b.transactions', 't')
            ->where('b.deleted = false')
            ->andWhere('b.startDate <= :startDate')
            ->andWhere('b.endDate >= :endDate')
            ->setParameter('startDate', new \DateTime('today'))
            ->setParameter('endDate', new \DateTime('tomorrow'))
            ->getQuery()->getResult()
        ;

        // This should show an overview and the current month
        return $this->render('budget/dashboard.html.twig', ['budgets' => $budgets]);
    }

    #[Route(path: '/new', methods: ['GET', 'POST'], priority: 10)]
    public function new(Request $request): Response
    {
        $budget = new Budget();

        $form = $this->createForm(BudgetType::class, $budget);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $budget->setCurrentValue($budget->getStartingValue());
            $this->em->persist($budget);
            $this->em->flush();

            return $this->dashboard();
        }

        return $this->render('budget/new.html.twig', ['form' => $form]);
    }

    #[Route(path: '/edit/{id}', methods: ['GET', 'PATCH'], priority: 10)]
    public function edit(Request $request, int $id): Response
    {
        $budget = $this->em->getRepository(Budget::class)->findOneBy(['id' => $id, 'deleted' => false]);
        if (!$budget instanceof Budget) {
            throw new NotFoundHttpException("Budget with id '{$id}' not found!");
        }

        $form = $this->createForm(
            BudgetType::class,
            $budget,
            ['action' => $this->generateUrl('app_budget_edit', ['id' => $budget->getId()])]
        );

        if ($request->isMethod('PATCH')) {
            $form->submit($request->getPayload()->all($form->getName()), false);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->em->persist($budget);
                $this->em->flush();

                return $this->render('budget/budget.html.twig', ['budget' => $budget]);
            }
        }

        return $this->render('budget/edit.html.twig', ['budget' => $budget, 'form' => $form]);
    }

    #[Route(path: '/delete/{id}', methods: 'DELETE', priority: 10)]
    public function delete(Request $request, int $id): Response
    {
        $budget = $this->em->getRepository(Budget::class)->findOneBy(['id' => $id, 'deleted' => false]);
        if (!$budget instanceof Budget) {
            throw new NotFoundHttpException("Budget with id '{$id}' not found!");
        }

        $budget->setDeleted(true);

        $this->em->persist($budget);
        $this->em->flush();

        return $this->dashboard();
    }
}
