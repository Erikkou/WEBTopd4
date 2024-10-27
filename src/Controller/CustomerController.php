<?php

namespace App\Controller;

use App\Entity\Customer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\CustomerType; // Ensure you have this form created
use Symfony\Component\HttpFoundation\Request;

class CustomerController extends AbstractController
{
    #[Route('/customer', name: 'app_customer')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $customers = $doctrine->getRepository(Customer::class)->findAll();

        return $this->render('customer/index.html.twig', [
            'customers' => $customers,
        ]);
    }

    #[Route('/customer/new', name: 'customer_new')]
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
        $customer = new Customer();
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($customer);
            $entityManager->flush();

            return $this->redirectToRoute('app_customer');
        }

        return $this->render('customer/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/customer/edit/{id}', name: 'customer_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Customer $customer, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('app_customer', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('customer/edit.html.twig', [
            'customer' => $customer,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/customer/delete/{id}', name: 'customer_delete', methods: ['POST'])]
    public function delete(Request $request, Customer $customer, ManagerRegistry $doctrine): Response
    {
        if ($this->isCsrfTokenValid('delete' . $customer->getId(), $request->request->get('_token'))) {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($customer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_customer', [], Response::HTTP_SEE_OTHER);
    }
}
