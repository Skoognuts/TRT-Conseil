<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Candidate;
use App\Repository\CandidateRepository;
use App\Form\CandidateCreationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class CandidateController extends AbstractController
{
    #[Route('/candidate', name: 'app_candidate')]
    public function index(CandidateRepository $candidateRepository, Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $currentUser = $this->getUser();

        $candidateEmail = $currentUser->getEmail();
        $candidateFirstName = '';
        $candidateLastName = '';
        $candidateCV = '';
        $fileError = '';
        $candidates = $candidateRepository->findAll();

        foreach ($candidates as $candidate) {
            if ($currentUser->getId() == $candidate->getUser()->getId()) {
                $candidateFirstName = $candidate->getFirstName();
                $candidateLastName = $candidate->getLastName();
                $candidateCV = $candidate->getCv();
            }
        }

        $newCandidate = new Candidate();
        $form = $this->createForm(CandidateCreationFormType::class, $newCandidate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newCandidate->setUser($currentUser);
            $newCandidate->setFirstName($form->get('firstName')->getData());
            $newCandidate->setLastName($form->get('lastName')->getData());

            $cv = $form->get('cv')->getData();
            $originalFilename = pathinfo($cv->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$cv->guessExtension();
            try {
                $cv->move(
                    $this->getParameter('cv_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                $fileError = $e;
            }

            $newCandidate->setCv($newFilename);

            $entityManager->persist($newCandidate);
            $entityManager->flush();

            return $this->redirectToRoute('app_candidate_created', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('candidate/index.html.twig', [
            'candidateEmail' => $candidateEmail,
            'candidateFirstName' => $candidateFirstName,
            'candidateLastName' => $candidateLastName,
            'candidateCV' => $candidateCV,
            'fileError' => $fileError,
            'candidateCreationForm' => $form->createView()
        ]);
    }

    #[Route('/candidate/candidate_created', name: 'app_candidate_created')]
    public function candidateCreated(CandidateRepository $candidateRepository): Response
    {
        $currentUser = $this->getUser();

        $candidates = $candidateRepository->findAll();

        foreach ($candidates as $candidate) {
            if ($currentUser->getId() == $candidate->getUser()->getId()) {
                $candidateFirstName = $candidate->getFirstName();
                $candidateLastName = $candidate->getLastName();
            }
        }

        return $this->render('candidate/candidate_created.html.twig', [
            'candidateFirstName' => $candidateFirstName,
            'candidateLastName' => $candidateLastName
        ]);
    }
}
