<?php

namespace App\Controller\Api;

use App\DTO\BookDTO\CreateBookDTO;
use App\DTO\BookDTO\UpdateBookDTO;
use App\Exception\DuplicateException;
use App\Exception\NotFoundException;
use App\Service\BookService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class BookController extends AbstractController
{
    public function __construct(
        private readonly BookService $bookService
    ) {
    }

    /**
     * @throws DuplicateException
     */
    #[Route('/api/create-book', name: 'api_book_create', methods: ['POST'])]
    public function createBook(CreateBookDTO $DTO): JsonResponse
    {
        $this->bookService->createBook($DTO);

        return new JsonResponse(['success' => 'Book has been created'], 200);
    }

    /**
     * @throws DuplicateException
     * @throws NotFoundException
     */
    #[Route('/api/update-book', name: 'api_book_update', methods: ['PUT'])]
    public function updateBook(UpdateBookDTO $DTO): JsonResponse
    {
        $book = $this->bookService->updateBook($DTO);

        return new JsonResponse(['success' => $book], 200);
    }

    #[Route('/api/get-book-list', name: 'api_book_get', methods: ['GET'])]
    public function getBookList(): JsonResponse
    {
        $book = $this->bookService->getBookList();

        return new JsonResponse(['books' => $book], 200);
    }

    /**
     * @throws NotFoundException
     */
    #[Route('/api/get-book-info/{id}', name: 'api_book_get_by_id', methods: ['GET'])]
    public function getBookById(int $id): JsonResponse
    {
        $book = $this->bookService->getBookInfo($id);

        return new JsonResponse(['book' => $book], 200);
    }

    /**
     * @throws NotFoundException
     */
    #[Route('/api/delete-book/{id}', name: 'api_book_delete', methods: ['DELETE'])]
    public function deleteBook(int $id): JsonResponse
    {
        $this->bookService->deleteBook($id);

        return new JsonResponse(['success' => 'Book has been deleted'], 200);
    }
}
