<?php

namespace App\Controller;

use App\Entity\Author;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\AuthorType;

class AuthorController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        $authors = $this->entityManager->getRepository(Author::class)->findAll();

        return $this->render('author/index.html.twig', [
            'authors' => $authors,
        ]);
    }

    #[Route('/author/new', name: 'author_new')]
    public function new(Request $request): Response
    {
        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($author);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_author');
        }

        return $this->render('author/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/author/delete/{id}', name: 'author_delete', methods: ['POST'])]
    public function delete(Request $request, Author $author): Response
    {
        if ($this->isCsrfTokenValid('delete' . $author->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($author);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('app_author', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/author/edit/{id}', name: 'author_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Author $author): Response
    {
        $form = $this->createForm(AuthorType::class, $author);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('app_author', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('author/edit.html.twig', [
            'author' => $author,
            'form' => $form->createView(),
        ]);
    }
}
