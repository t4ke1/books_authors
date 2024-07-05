<?php

namespace App\Controller\Api;

use App\DTO\AuthorDTO\UpdateAuthorDTO;
use App\Exception\NotFoundException;
use App\Service\AuthorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class AuthorController extends AbstractController
{
    public function __construct(
        private AuthorService $authorService
    ) {
    }

    #[Route('/api/get-authors', name: 'api_author_get', methods: ['GET'])]
    public function getAuthors(): JsonResponse
    {
        $authors = $this->authorService->getAuthorList();

        return new JsonResponse(['authors' => $authors], 200);
    }

    /**
     * @throws NotFoundException
     */
    #[Route('/api/get-author/{id}', name: 'api_author_get_by_id', methods: ['GET'])]
    public function getAuthorInfo(int $id): JsonResponse
    {
        $authorInfo = $this->authorService->getAuthorInfo($id);

        return new JsonResponse(['authorInfo' => $authorInfo], 200);
    }

    /**
     * @throws NotFoundException
     */
    #[Route('/api/update-author', name: 'api_author_update', methods: ['PUT'])]
    public function updateAuthor(UpdateAuthorDTO $DTO): JsonResponse
    {
        $this->authorService->updateAuthor($DTO);

        return new JsonResponse(['success' => 'Author has been updated'], 200);
    }
}
