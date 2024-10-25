<?php

namespace App\Controller;

use App\Model\Car\CreateCarRequest;
use App\Model\Car\UpdateCarRequest;
use App\Service\CarService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class CarController extends AbstractController
{
    public function __construct(
        private readonly CarService $carService
    ) {
    }

    #[Route('/api/v1/car', methods: ['GET'])]
    public function getCars(): JsonResponse
    {
        return $this->json($this->carService->getCars());
    }

    #[Route('/api/v1/admin/car', methods: ['POST'])]
    public function createCar(#[MapRequestPayload] CreateCarRequest $request): JsonResponse
    {
        return $this->json($this->carService->createCar($request));
    }

    #[Route('/api/v1/admin/car/{id}', requirements: ['id' => '\d+'], methods: ['PUT'])]
    #[Route('/api/v1/manager/car/{id}', requirements: ['id' => '\d+'], methods: ['PUT'])]
    public function updateCar(int $id, #[MapRequestPayload] UpdateCarRequest $request): JsonResponse
    {
        $this->carService->updateCar($id, $request);

        return $this->json(null);
    }

    #[Route("/api/v1/admin/car/{id}", requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function deleteCar(int $id): JsonResponse
    {
        $this->carService->deleteCar($id);

        return $this->json(null);
    }
}
