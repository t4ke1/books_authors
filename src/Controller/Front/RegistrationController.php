<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/registration', name: 'registration')]
    public function index(): Response
    {
        return $this->render('registration.html.twig');
    }

    #[Route('/verify', name: 'verify')]
    public function verify(): Response
    {
        return $this->render('verify.html.twig');
    }

    #[Route('/login', name: 'confirm')]
    public function confirm(): Response
    {
        return $this->render('login.html.twig');
    }
}
