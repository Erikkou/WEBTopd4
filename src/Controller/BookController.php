<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\LoanStatus; // Add this import
use App\Form\BookType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(ManagerRegistry $doctrine): Response
    {

        $books = $doctrine->getRepository(Book::class)->findAll();

        return $this->render('book/index.html.twig', [
            'books' => $books,
        ]);
    }

    #[Route('/book/new', name: 'book_new')]
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
        $book = new Book();

        $form = $this->createForm(BookType::class, $book, [
            'is_new' => true, // Set to true for new book
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Fetch the LoanStatus corresponding to "Available"
            $availableLoanStatus = $doctrine->getRepository(LoanStatus::class)->findOneBy(['status' => 'Available']);
            $book->setLoanID($availableLoanStatus); // Set the loan status to available

            $entityManager = $doctrine->getManager();
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('app_book');
        }

        return $this->render('book/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }



    #[Route('/book/edit/{id}', name: 'book_edit')]
    public function edit(Request $request, ManagerRegistry $doctrine, $id): Response
    {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Book::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException('No book found for id ' . $id);
        }

        // Fetch all available loan statuses
        $loanStatuses = $entityManager->getRepository(LoanStatus::class)->findBy([], ['id' => 'ASC']); // Fetch statuses ordered by id or any other relevant field

        $form = $this->createForm(BookType::class, $book, [
            'is_new' => false, // Set to false for edit
            'loan_statuses' => $loanStatuses, // Pass available loan statuses
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_book');
        }

        return $this->render('book/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }




    #[Route('/book/{id}/delete', name: 'book_delete')]
    public function delete(int $id, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $book = $doctrine->getRepository(Book::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException('No book found for id ' . $id);
        }

        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute('app_book');
    }





}
