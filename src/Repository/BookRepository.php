<?php

namespace App\Repository;

use App\Entity\Author;
use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Book::class);
    }

    public function duplicateBook(string $name, array $authors): bool
    {
        $book = $this->findOneBy(['name' => $name]);
        if (null === $book) {
            return true;
        }
        $authorsNames = array_map('strtolower', $authors);
        $bookAuthors = $book->getAuthor();
        foreach ($bookAuthors as $author) {
            $key = array_search(strtolower($author->getName()), $authorsNames);
            if (false !== $key) {
                unset($authorsNames[$key]);
            }
        }
        if (0 === count($authorsNames)) {
            return false;
        }

        return true;
    }

    public function addAuthor(Book $book, array $authors): void
    {
        foreach ($authors as $authorName) {
            $authorEntity = $this->entityManager->getRepository(Author::class)->findOneBy(['name' => $authorName]);
            if (null === $authorEntity) {
                $author = new Author();
                $author
                    ->setName($authorName)
                    ->addBook($book);
            } else {
                $author = $authorEntity;
                $author->addBook($book);
            }
            $book->addAuthor($author);
        }
    }

    public function updateAuthor(Book $book, array $authors): void
    {
        foreach ($book->getAuthor() as $author) {
            $book->removeAuthor($author);
        }

        foreach ($authors as $authorName) {
            $authorEntity = $this->entityManager->getRepository(Author::class)->findOneBy(['name' => $authorName]);
            if (null === $authorEntity) {
                $author = new Author();
                $author
                    ->setName($authorName)
                    ->addBook($book);
            } else {
                $author = $authorEntity;
                $author->addBook($book);
            }
            $book->addAuthor($author);
        }
    }
}
