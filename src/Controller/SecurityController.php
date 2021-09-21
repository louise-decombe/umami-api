<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{

    #[Route(path: '/api/login', name: 'api_login', methods: ['POST'])]
    public  function login(): \Symfony\Component\HttpFoundation\JsonResponse
    {

        $user = $this->getUser();
        return $this->json([
            'username' => $user->getUsername()

        ]);

    }

}