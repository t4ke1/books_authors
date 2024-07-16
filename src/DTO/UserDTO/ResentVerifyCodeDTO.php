<?php

namespace App\DTO\UserDTO;

use App\DTO\ValueResolvedInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ResentVerifyCodeDTO implements ValueResolvedInterface
{
    #[Assert\NotBlank]
    #[Assert\Email]
    private string $email;

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
