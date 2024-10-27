<?php

namespace App\Controller;

use App\Entity\LoanStatus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class LoanStatusController extends AbstractController
{
    #[Route('/loan/status', name: 'app_loan_status')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $loanstatuses = $doctrine->getRepository(LoanStatus::class)->findAll();

        return $this->render('loan_status/index.html.twig', [
            'loanstatuses' => $loanstatuses,
        ]);
    }
}