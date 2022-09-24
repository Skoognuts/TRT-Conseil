<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\CandidateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CandidateController extends AbstractController
{
    #[Route('/candidate', name: 'app_candidate')]
    public function index(CandidateRepository $candidateRepository): Response
    {
        $currentUser = $this->getUser();

        $candidateEmail = $currentUser->getEmail();
        $candidateFirstName = '';
        $candidateLastName = '';
        $candidates = $candidateRepository->findAll();

        foreach ($candidates as $candidate) {
            if ($currentUser->getId() == $candidate->getUser()->getId()) {
                $candidateFirstName = $candidate->getFirstName();
                $candidateLastName = $candidate->getLastName();
            }
        }

        return $this->render('candidate/index.html.twig', [
            'candidateEmail' => $candidateEmail,
            'candidateFirstName' => $candidateFirstName,
            'candidateLastName' => $candidateLastName
        ]);
    }
}
