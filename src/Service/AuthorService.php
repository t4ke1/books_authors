<?php

namespace App\Service;

use App\DTO\AuthorDTO\UpdateAuthorDTO;
use App\Entity\Author;
use App\Entity\Book;
use App\Exception\NotFoundException;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;

class AuthorService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private AuthorRepository $authorRepository
    ) {
    }

    public function getAuthorList(): array
    {
        $authors = $this->entityManager->getRepository(Author::class)->findAll();
        $authorData = [];
        foreach ($authors as $author) {
            $authorData[] = [
                'id' => $author->getId(),
                'name' => $author->getName(),
            ];
        }

        return $authorData;
    }

    /**
     * @throws NotFoundException
     */
    public function getAuthorInfo(int $id): array
    {

        $author = $this->entityManager->getRepository(Author::class)->findOneBy(['id' => $id]);
        if (null === $author) {
            throw new NotFoundException();
        }
        $books = [];
        foreach ($author->getBooks() as $book) {
            $books[] = $book->getName();
        }

        return [
            'id' => $author->getId(),
            'name' => $author->getName(),
            'bookCount' => $author->getBookCount(),
            'books' => $books
        ];
    }

    /**
     * @throws NotFoundException
     */
    public function updateAuthor(UpdateAuthorDTO $DTO): bool
    {
        $author = $this->entityManager->getRepository(Author::class)->findOneBy(['id' => $DTO->getId()]);
        if (null === $author) {
            throw new NotFoundException();
        }
        if (($DTO->getName() !== $author->getName()) && (null !== $DTO->getName())) {
            $author->setName($DTO->getName());
        }

        $this->entityManager->persist($author);
        $this->entityManager->flush();

        return true;
    }

    /**
     * @throws NotFoundException
     */
    public function deleteAuthor($id): bool
    {
        $author = $this->entityManager->getRepository(Author::class)->findOneBy(['id' => $id]);
        if (null === $author) {
            throw new NotFoundException();
        }
        $this->entityManager->remove($author);
        $this->entityManager->flush();

        return true;
    }
}
