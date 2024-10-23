<?php

namespace App\Controller;

use App\Model\Car\CreateCarRequest;
use App\Model\Car\UpdateCarRequest;
use App\Model\CarBrand\UpdateCarBrandRequest;
use App\Service\CarBrandService;
use App\Service\CarService;
use App\Model\CarBrand\CreateCarBrandRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class AdminController extends AbstractController
{
    public function __construct(
        private readonly CarBrandService $carBrandService,
        private readonly CarService $carService
    ) {
    }
    #[Route('/api/v1/admin/car-brand', methods: ['GET'])]
    public function carBrands(): JsonResponse
    {
        return $this->json($this->carBrandService->getCarBrands());
    }

    #[Route('/api/v1/admin/car-brand', methods: ['POST'])]
    public function createCarBrand(#[MapRequestPayload] CreateCarBrandRequest $request): JsonResponse
    {
        return $this->json($this->carBrandService->createCarBrand($request));
    }

    #[Route('/api/v1/admin/car-brand/{id}', methods: ['PUT'])]
    public function updateCarBrand(int $id, #[MapRequestPayload] UpdateCarBrandRequest $request): JsonResponse
    {
        $this->carBrandService->updateCarBrand($id, $request);

        return $this->json(null);
    }

    #[Route('/api/v1/admin/car-brand/{id}', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function deleteCarBrand(int $id): JsonResponse
    {
        $this->carBrandService->deleteCarBrand($id);

        return $this->json(null);
    }

    #[Route('/api/v1/admin/car', methods: ['GET'])]
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
