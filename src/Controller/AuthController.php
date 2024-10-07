<?php

namespace App\Controller;

use App\Model\SignUpRequest;
use App\Service\AuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class AuthController extends AbstractController
{
    public function __construct(private readonly AuthService $authService)
    {
    }
    #[Route('/auth', name: 'app_auth')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/AuthController.php',
        ]);
    }

    #[Route('/auth/sign-up', name: 'app_auth_sign_up', methods: ['POST'])]
    public function signUp(#[MapRequestPayload] SignUpRequest $signUpRequest): JsonResponse
    {
        return $this->authService->signUp($signUpRequest);
    }

    public function me(#[CurrentUser] UserInterface $user): JsonResponse
    {
        return $this->json($user);
    }
}