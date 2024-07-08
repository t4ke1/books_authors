<?php

namespace App\Service;

use App\DTO\UserDTO\CreateUserDTO;
use App\DTO\UserDTO\VerifyUserDTO;
use App\Entity\Users;
use App\Exception\BadRequestException;
use App\Exception\DuplicateException;
use App\Exception\NotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AuthService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher,
        private MailService $mailService
    ) {
    }

    /**
     * @throws DuplicateException
     * @throws TransportExceptionInterface
     */
    public function createUser(CreateUserDTO $DTO): Users
    {
        $userRepo = $this->entityManager->getRepository(Users::class);

        if ((null !== $userRepo->findOneBy(['name' => $DTO->getName()])) || (null !== $userRepo->findOneBy(['email' => $DTO->getEmail()]))) {
            throw new DuplicateException();
        }
        $token = mt_rand(100000, 999999);
        $user = new Users();
        $user
            ->setName($DTO->getName())
            ->setEmail($DTO->getEmail())
            ->setToken($token);
        $hashedPassword = $this->passwordHasher->hashPassword($user, $DTO->getPassword());
        $user->setPassword($hashedPassword);
        $this->mailService->sendCode(MailService::SUBJECT_VERIFY_CODE, $DTO->getEmail(), $token);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    /**
     * @throws NotFoundException
     * @throws BadRequestException
     */
    public function verifyUser(VerifyUserDTO $DTO): Users
    {
        $user = $this->entityManager->getRepository(Users::class)->findOneBy(['email' => $DTO->getEmail()]);
        if (null === $user) {
            throw new NotFoundException();
        }
        if ($user->getToken() !== intval($DTO->getToken())) {
            throw new BadRequestException();
        }
        $user
            ->setVerify(true)
            ->setToken(null)
            ->setRole(Users::ROLE_USER);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
