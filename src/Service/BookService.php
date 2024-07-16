<?php

namespace App\Service;

use App\DTO\BookDTO\CreateBookDTO;
use App\DTO\BookDTO\UpdateBookDTO;
use App\Entity\Book;
use App\Exception\DuplicateException;
use App\Exception\NotFoundException;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;

class BookService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private BookRepository $bookRepository,
    ) {
    }

    /**
     * @throws DuplicateException
     */
    public function createBook(CreateBookDTO $DTO): Book
    {
        if (!$this->bookRepository->duplicateBook($DTO->getName(), $DTO->getAuthor())) {
            throw new DuplicateException();
        }

        $this->entityManager->getRepository(Book::class)->findOneBy(['name' => $DTO->getName()]);
        $book = new Book();
        $book
            ->setName($DTO->getName())
            ->setGenre($DTO->getGenre());
        $this->bookRepository->addAuthor($book, $DTO->getAuthor());
        $this->entityManager->persist($book);
        $this->entityManager->flush();

        return $book;
    }

    /**
     * @throws NotFoundException
     * @throws DuplicateException
     */
    public function updateBook(UpdateBookDTO $DTO): bool
    {
        $book = $this->entityManager->getRepository(Book::class)->findOneBy(['id' => $DTO->getId()]);
        if (null === $book) {
            throw new NotFoundException();
        }
        if ((null !== $DTO->getName()) && ($DTO->getName() !== $book->getName())) {
            $book->setName($DTO->getName());
        }
        if ((null !== $DTO->getGenre()) && ($DTO->getGenre() !== $book->getGenre())) {
            $book->setGenre($DTO->getGenre());
        }
        if (!$this->bookRepository->duplicateBook($book->getName(), $DTO->getAuthor())) {
            throw new DuplicateException();
        }
        $this->bookRepository->updateAuthor($book, $DTO->getAuthor());
        $this->entityManager->persist($book);
        $this->entityManager->flush();

        return true;
    }

    /**
     * @throws NotFoundException
     */
    public function deleteBook(int $id): bool
    {
        $book = $this->entityManager->getRepository(Book::class)->findOneBy(['id' => $id]);
        if (null === $book) {
            throw new NotFoundException();
        }
        $this->entityManager->remove($book);
        foreach ($book->getAuthor() as $author) {
            $book->removeAuthor($author);
        }
        $this->entityManager->flush();

        return true;
    }

    public function getBookInfo(int $id): array
    {
        $book = $this->entityManager->getRepository(Book::class)->findOneBy(['id' => $id]);
        if (null === $book) {
            throw new NotFoundException();
        }
        $authors = [];
        foreach ($book->getAuthor() as $author) {
            $authors[] = $author->getName();
        }

        return [
            'id' => $book->getId(),
            'name' => $book->getName(),
            'genre' => $book->getGenre(),
            'author' => $authors,
        ];
    }

    public function getBookList(): array
    {
        $books = $this->entityManager->getRepository(Book::class)->findAll();
        $booksData = [];
        foreach ($books as $book) {
            $booksData[] = [
                'id' => $book->getId(),
                'name' => $book->getName(),
            ];
        }

        return $booksData;
    }
}
