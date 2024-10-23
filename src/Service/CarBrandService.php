<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\CarBrand;
use App\Exception\CarBrandAlreadyExistsException;
use App\Exception\CustomException;
use App\Model\CarBrandListItem;
use App\Model\CarBrandListResponse;
use App\Model\CreateCarBrandRequest;
use App\Model\IdResponse;
use App\Model\UpdateCarBrandRequest;
use App\Repository\CarBrandRepository;
use DomainException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CarBrandService
{
    public function __construct(
        private readonly CarBrandRepository $carBrandRepository
    ) {
    }

    public function getCarBrands(): CarBrandListResponse
    {
        $carBrands = $this->carBrandRepository->findAllSortedByName();
        $items = array_map(
            fn (CarBrand $carBrand) => new CarBrandListItem(
                $carBrand->getId(),
                $carBrand->getName(),
            ),
            $carBrands
        );

        return new CarBrandListResponse($items);
    }

    public function getCarBrand(int $id): CarBrandListItem
    {
        $carBrand = $this->carBrandRepository->getCarBrandById($id);

        return new CarBrandListItem($carBrand->getId(), $carBrand->getName());
    }

    public function createCarBrand(CreateCarBrandRequest $request): JsonResponse
    {
        if ($this->carBrandRepository->existsByName($request->getName())) {
            throw new CarBrandAlreadyExistsException();
        }

        $carBrand = (new CarBrand())->setName($request->getName());
        $this->carBrandRepository->saveAndCommit($carBrand);

        return new JsonResponse(null, Response::HTTP_CREATED);
    }

    public function updateCarBrand(int $id, UpdateCarBrandRequest $request): void
    {
        $carBrand = $this->carBrandRepository->getCarBrandById($id);
        if ($request->getName() !== $carBrand->getName() && $this->carBrandRepository->existsByName($request->getName())) {
            throw new CarBrandAlreadyExistsException();
        }
        $carBrand->setName($request->getName());
        $this->carBrandRepository->commit();
    }

    public function deleteCarBrand(int $id): void
    {
        $carBrand = $this->carBrandRepository->getCarBrandById($id);
        $this->carBrandRepository->removeAndCommit($carBrand);
    }
}
