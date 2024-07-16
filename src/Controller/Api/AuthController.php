<?php

namespace App\Controller\Api;

use App\DTO\UserDTO\CreateUserDTO;
use App\DTO\UserDTO\ResentVerifyCodeDTO;
use App\DTO\UserDTO\VerifyUserDTO;
use App\Exception\BadRequestException;
use App\Exception\DuplicateException;
use App\Exception\NotFoundException;
use App\Service\AuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Attribute\Route;

class AuthController extends AbstractController
{
    public function __construct(
        private readonly AuthService $userService
    ) {
    }

    /**
     * @throws DuplicateException
     * @throws TransportExceptionInterface
     */
    #[Route('/api/create-user', name: 'api_user_create', methods: ['POST'])]
    public function createUser(CreateUserDTO $DTO): JsonResponse
    {
        $this->userService->createUser($DTO);

        return new JsonResponse(['success' => 'User has been created, verify code has been sent'], 200);
    }

    /**
     * @throws BadRequestException
     * @throws NotFoundException
     */
    #[Route('/api/verify-user', name: 'api_user_verify', methods: ['POST'])]
    public function verifyUser(VerifyUserDTO $DTO): JsonResponse
    {
        $this->userService->verifyUser($DTO);

        return new JsonResponse(['success' => 'Your account has been verified'], 200);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws NotFoundException
     */
    #[Route('/api/resent-verify-code', name: 'api_user_resent_verify_code', methods: ['POST'])]
    public function resentVerifyCode(ResentVerifyCodeDTO $DTO): JsonResponse
    {
        $this->userService->resendVerifyCode($DTO);

        return new JsonResponse(['success' => 'Verify code has been sent'], 200);
    }
}
