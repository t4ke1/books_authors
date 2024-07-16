<?php

namespace App\Controller\Front;

use App\Service\AuthorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AuthorController extends AbstractController
{
    public function __construct(
        private readonly AuthorService $authorService
    ) {
    }

    #[Route('/author', name: 'author')]
    public function index(): Response
    {
        $authors = $this->authorService->getAuthorList();

        return $this->render('author.html.twig',
            [
                'authors' => $authors,
            ]);
    }
}
