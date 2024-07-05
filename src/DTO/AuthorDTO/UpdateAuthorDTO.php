<?php

namespace App\DTO\AuthorDTO;

use App\DTO\ValueResolvedInterface;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateAuthorDTO implements ValueResolvedInterface
{
    #[Assert\NotBlank]
    #[Assert\Type('int')]
    private int $id;

    #[Assert\Type('string')]
    private ?string $name;

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

}
