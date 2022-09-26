<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Recruiter;
use App\Repository\RecruiterRepository;
use App\Form\RecruiterCreationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecruiterController extends AbstractController
{
    #[Route('/recruiter', name: 'app_recruiter')]
    public function index(RecruiterRepository $recruiterRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $currentUser = $this->getUser();

        $recruitEmail = $currentUser->getEmail();
        $recruitCompany = '';
        $recruitAddress = '';
        $recruiters = $recruiterRepository->findAll();

        foreach ($recruiters as $recruiter) {
            if ($currentUser->getId() == $recruiter->getUser()->getId()) {
                $recruitCompany = $recruiter->getCompany();
                $recruitAddress = $recruiter->getAddress();
            }
        }

        $newRecruiter = new Recruiter();
        $form = $this->createForm(RecruiterCreationFormType::class, $newRecruiter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newRecruiter->setUser($currentUser);
            $newRecruiter->setCompany($form->get('company')->getData());
            $newRecruiter->setAddress($form->get('address')->getData());

            $entityManager->persist($newRecruiter);
            $entityManager->flush();

            return $this->redirectToRoute('app_recruiter_created', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('recruiter/index.html.twig', [
            'recruitEmail' => $recruitEmail,
            'recruitCompany' => $recruitCompany,
            'recruitAddress' => $recruitAddress,
            'recruiterCreationForm' => $form->createView()
        ]);
    }

    #[Route('recruiter/recruiter_created', name: 'app_recruiter_created')]
    public function recruiterCreated(RecruiterRepository $recruiterRepository): Response
    {
        $currentUser = $this->getUser();

        $recruiters = $recruiterRepository->findAll();

        foreach ($recruiters as $recruiter) {
            if ($currentUser->getId() == $recruiter->getUser()->getId()) {
                $recruitCompany = $recruiter->getCompany();
                $recruitAddress = $recruiter->getAddress();
            }
        }

        return $this->render('recruiter/recruiter_created.html.twig', [
            'recruitCompany' => $recruitCompany,
            'recruitAddress' => $recruitAddress
        ]);
    }
}
