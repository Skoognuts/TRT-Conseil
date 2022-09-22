<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WaitForValidationController extends AbstractController
{
    #[Route('/wait_for_validation', name: 'app_wait_for_validation')]
    public function index(): Response
    {
        return $this->render('wait_for_validation/index.html.twig', [
            'controller_name' => 'WaitForValidationController',
        ]);
    }
}
