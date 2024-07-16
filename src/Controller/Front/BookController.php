<?php

namespace App\Controller\Front;

use App\Service\BookService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BookController extends AbstractController
{
    public function __construct(
        private readonly BookService $bookService
    ) {
    }

    #[Route('/book', name: 'book')]
    public function index(): Response
    {
        $books = $this->bookService->getBookList();

        return $this->render('book.html.twig',
            [
                'books' => $books,
            ]);
    }
}
