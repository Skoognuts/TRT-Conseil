<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\RecruiterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecruiterController extends AbstractController
{
    #[Route('/recruiter', name: 'app_recruiter')]
    public function index(RecruiterRepository $recruiterRepository): Response
    {
        $currentUser = $this->getUser();

        $recruitEmail = $currentUser->getEmail();
        $recruitCompany = '';
        $recruiters = $recruiterRepository->findAll();

        foreach ($recruiters as $recruiter) {
            if ($currentUser->getId() == $recruiter->getUser()->getId()) {
                $recruitCompany = $recruiter->getCompany();
            }
        }

        return $this->render('recruiter/index.html.twig', [
            'recruitEmail' => $recruitEmail,
            'recruitCompany' => $recruitCompany
        ]);
    }
}
