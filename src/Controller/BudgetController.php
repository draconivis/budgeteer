<?php

namespace App\Controller;

use App\Entity\Budget;
use App\Entity\Transaction;
use App\Form\Type\BudgetType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

    #[Route(path: '/dash')]
    public function dashboard(): Response
    {
        /** @var Budget[] $budgets */
        $budgets = $this->em->createQueryBuilder()
            ->select('b')
            ->from(Budget::class, 'b')
            ->leftJoin('b.transactions', 't')
            ->where('b.owner = :userId')
            ->andWhere('b.startDate <= :now')
            ->andWhere('b.endDate >= :now')
            ->setParameter('userId', $this->getUser())
            ->setParameter('now', new \DateTime())
            ->getQuery()->getResult()
        ;

        // This should show an overview and the current month
        return $this->render('budget/dashboard.html.twig', ['budgets' => $budgets]);
    }

    #[Route(path: '/{year}')]
    public function showBudgetByYear(): Response
    {
        // This should show all months of that year
        return $this->render('budget/byYear.html.twig');
    }

    #[Route(path: '/{year}/{month}')]
    public function showBudgetByYearAndMonth(): Response
    {
        // This should show a detailed view of the current month
        return $this->render('budget/byYearAndMonth.html.twig');
    }

    #[Route(path: '/new', priority: 10)]
    public function new(Request $request): Response
    {
        $budget = new Budget();
        // $budget->setOwner($this->getUser());

        $form = $this->createForm(BudgetType::class, $budget);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $budget->setOwner($this->getUser());
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            // $budget = $form->getData();

            $this->em->persist($budget);
            $this->em->flush();

            return $this->redirectToRoute('app_budget_dashboard');
        }

        return $this->render('budget/new.html.twig', ['form' => $form]);
    }
}
