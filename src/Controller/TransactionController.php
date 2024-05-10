<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/transaction')]
class TransactionController extends AbstractController
{
    #[Route(path: '')]
    public function index(): Response
    {
        return $this->render('budget/index.html.twig');
    }
}
