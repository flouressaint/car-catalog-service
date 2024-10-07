<?php

namespace App\Controller;

use App\Model\CreateCarBrandRequest;
use App\Model\UpdateCarBrandRequest;
use App\Service\CarBrandService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class AdminController extends AbstractController
{
    public function __construct(
        private readonly CarBrandService $carBrandService,
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


}
