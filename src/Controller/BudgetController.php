<?php

namespace App\Controller;

use App\Entity\Budget;
use App\Repository\BudgetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

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
        /** @var BudgetRepository $budgetRepo */
        $budgetRepo = $this->em->getRepository(Budget::class);

        /** @var ?Budget $budget */
        $budget = $budgetRepo->find(1);
        if (null === $budget) {
            $budget = new Budget();
            $budget->setCurrentValue(0);
            $this->em->persist($budget);
            $this->em->flush();
        }

        // This should show an overview
        return $this->render('budget/dashboard.html.twig', ['budget' => $budget]);
    }
}
