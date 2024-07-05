<?php

namespace App\DTO\UserDTO;

use App\DTO\ValueResolvedInterface;
use Symfony\Component\Validator\Constraints as Assert;

class VerifyUserDTO implements ValueResolvedInterface
{
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Assert\Length(exactly: 6)]
    private string $token;

    #[Assert\NotBlank]
    #[Assert\Email]
    private string $email;

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
}
