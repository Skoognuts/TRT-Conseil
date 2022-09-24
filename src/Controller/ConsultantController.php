<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ConsultantRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConsultantController extends AbstractController
{
    #[Route('/consultant', name: 'app_consultant')]
    public function index(ConsultantRepository $consultantRepository, UserRepository $userRepository): Response
    {
        $currentUser = $this->getUser();

        $consultants = $consultantRepository->findAll();

        foreach ($consultants as $consultant) {
            if ($currentUser->getId() == $consultant->getUser()->getId()) {
                $consultFirstName = $consultant->getFirstName();
                $consultLastName = $consultant->getLastName();
            }
        }

        $candidates = $userRepository->findBy(array('userType' => 4), array('id' => 'ASC'));
        $unauthorizedCandidates = [];

        foreach ($candidates as $candidate) {
            if ($candidate->getRoles() == ["ROLE_UNAUTHORIZED"]) {
                array_push($unauthorizedCandidates, $candidate);
            }
        }

        $recruiters = $userRepository->findBy(array('userType' => 3), array('id' => 'ASC'));
        $unauthorizedRecruiters = [];

        foreach ($recruiters as $recruiter) {
            if ($recruiter->getRoles() == ["ROLE_UNAUTHORIZED"]) {
                array_push($unauthorizedRecruiters, $recruiter);
            }
        }

        // Annonces à approuver
        $jobOffersToApprove = [];

        // Candidatures à approuver
        $jobApplicationsToApprove = [];

        return $this->render('consultant/index.html.twig', [
            'unauthorizedCandidates' => $unauthorizedCandidates,
            'unauthorizedRecruiters' => $unauthorizedRecruiters,
            'jobOffersToApprove' => $jobOffersToApprove,
            'jobApplicationsToApprove' => $jobApplicationsToApprove,
            'consultFirstName' => $consultFirstName,
            'consultLastName' => $consultLastName
        ]);
    }

    #[Route('/consultant-grant-candidate-{id}', name: 'app_consultant_grant_candidate', methods: ['GET', 'POST'])]
    public function grant_candidate(ConsultantRepository $consultantRepository, User $user, EntityManagerInterface $entityManager): Response
    {
        $currentUser = $this->getUser();

        $consultants = $consultantRepository->findAll();

        foreach ($consultants as $consultant) {
            if ($currentUser->getId() == $consultant->getUser()->getId()) {
                $consultFirstName = $consultant->getFirstName();
                $consultLastName = $consultant->getLastName();
            }
        }

        $user->setRoles(["ROLE_CANDIDATE"]);
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->render('consultant/grant_candidate.html.twig', [
            'candidate' => $user,
            'consultFirstName' => $consultFirstName,
            'consultLastName' => $consultLastName
        ]);
    }

    #[Route('/consultant-grant-recruiter-{id}', name: 'app_consultant_grant_recruiter', methods: ['GET', 'POST'])]
    public function grant_recruiter(ConsultantRepository $consultantRepository, User $user, EntityManagerInterface $entityManager): Response
    {
        $currentUser = $this->getUser();

        $consultants = $consultantRepository->findAll();

        foreach ($consultants as $consultant) {
            if ($currentUser->getId() == $consultant->getUser()->getId()) {
                $consultFirstName = $consultant->getFirstName();
                $consultLastName = $consultant->getLastName();
            }
        }

        $user->setRoles(["ROLE_RECRUITER"]);
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->render('consultant/grant_recruiter.html.twig', [
            'recruiter' => $user,
            'consultFirstName' => $consultFirstName,
            'consultLastName' => $consultLastName
        ]);
    }
}
