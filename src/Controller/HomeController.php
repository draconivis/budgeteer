<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    public function __construct()
    {
    }

    #[Route(path: '/', name: 'homePage', methods: "GET")]
    public function homePage(): Response {
        return $this->render('base.html.twig');
    }
}
