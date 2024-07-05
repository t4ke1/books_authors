<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;

#[ORM\Entity(repositoryClass: AuthorRepository::class)]
#[ORM\Table(name: 'author')]
#[ORM\HasLifecycleCallbacks]
class Author
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', unique: true, nullable: false)]
    private int $id;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private string $name;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $bookCount = 0;

    /**
     * Many Groups have Many Users.
     *
     * @var Collection<int, Book>
     */
    #[ManyToMany(targetEntity: Book::class, mappedBy: 'authors', cascade: ['persist'])]
    private Collection $books;
    #[ORM\Column(type: 'datetime', nullable: false)]
    private \DateTime $createdAt;
    #[ORM\Column(type: 'datetime', nullable: false)]
    private \DateTime $updatedAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getBookCount(): int
    {
        return $this->bookCount;
    }

    public function setBookCount(int $bookCount): self
    {
        $this->bookCount = $bookCount;

        return $this;
    }

    public function __construct()
    {
        $this->books = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**
     * @return Collection<int, Book>
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): self
    {
        $this->books[] = $book;
        $bookCount = $this->getBookCount() + 1;
        $this->setBookCount($bookCount);
        return $this;
    }

    public function removeBook(Book $book): void
    {
        $this->books->removeElement($book);
        $bookCount = $this->getBookCount() - 1;
        $this->setBookCount($bookCount);
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    #[ORM\PreFlush]
    public function preFlush(): void
    {
        $this->updatedAt = new \DateTime();
    }
}
