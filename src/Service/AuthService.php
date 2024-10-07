<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Model\SignUpRequest;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AuthService
{
    public function __construct(
        private readonly UserPasswordHasherInterface $hasher,
        private readonly UserRepository $userRepository,
    ) {
    }

    public function signUp(SignUpRequest $signUpRequest): Response
    {
        if ($this->userRepository->existsByUsername($signUpRequest->getUsername())) {
            throw new \DomainException("User already exists", Response::HTTP_CONFLICT);
        }

        $user = (new User())
            ->setRoles(['ROLE_USER'])
            ->setUsername($signUpRequest->getUsername());

        $user->setPassword($this->hasher->hashPassword($user, $signUpRequest->getPassword()));

        $this->userRepository->saveAndCommit($user);

        return new JsonResponse(null, Response::HTTP_CREATED);
    }
}
