<?php

namespace App\DTO\BookDTO;

use App\DTO\ValueResolvedInterface;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateBookDTO implements ValueResolvedInterface
{
    #[Assert\NotBlank]
    #[Assert\Type('integer')]
    private int $id;
    #[Assert\Type('string')]
    private ?string $name;

    #[Assert\Type('string')]
    private ?string $genre;

    /**
     * @return string[]|null
     */
    #[Assert\Type('array')]
    #[Assert\All([
        new Assert\Type('string'),
    ])]
    private ?array $author;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getAuthor(): ?array
    {
        return $this->author;
    }

    public function setAuthor(?array $author): self
    {
        $this->author = $author;

        return $this;
    }
}
