<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Car;
use App\Exception\CarAlreadyExistsException;
use App\Model\Car\CarListItem;
use App\Model\Car\CarListResponse;
use App\Model\Car\CreateCarRequest;
use App\Model\Car\UpdateCarRequest;
use App\Model\CarBrand\CarBrandListItem;
use App\Model\IdResponse;
use App\Repository\CarBrandRepository;
use App\Repository\CarRepository;

class CarService
{
    public function __construct(
        private readonly CarRepository $carRepository,
        private readonly CarBrandRepository $carBrandRepository
    ) {
    }

    public function getCars(): CarListResponse
    {
        $cars = $this->carRepository->findAll();
        $items = array_map(
            fn (Car $car) => new CarListItem(
                $car->getId(),
                $car->getModel(),
                new CarBrandListItem($car->getBrand()->getId(), $car->getBrand()->getName()),
                $car->isLeftHandDrive(),
            ),
            $cars
        );

        return new CarListResponse($items);
    }

    public function createCar(CreateCarRequest $request): IdResponse
    {
        if ($this->carRepository->exists($request->getBrandId(), $request->getModel(), $request->getLeftHandDrive())) {
            throw new CarAlreadyExistsException();
        }

        $car = (new Car())
            ->setModel($request->getModel())
            ->setBrand($this->carBrandRepository->getCarBrandById($request->getBrandId()))
            ->setLeftHandDrive($request->getLeftHandDrive());
        $this->carRepository->saveAndCommit($car);

        return new IdResponse($car->getId());
    }

    public function updateCar(int $id, UpdateCarRequest $request): void
    {
        $car = $this->carRepository->getCarById($id);
        $duplicate = $this->carRepository->findOneBy(
            ['model' => $request->getModel(),
            'brand' => $this->carBrandRepository->getCarBrandById($request->getBrandId()),
            'leftHandDrive' => $request->getLeftHandDrive()]
        );

        if ($duplicate && $duplicate->getId() !== $id) {
            throw new CarAlreadyExistsException();
        }
        if (null !== $request->getModel()) {
            $car->setModel($request->getModel());
        }
        if (null !== $request->getBrandId()) {
            $car->setBrand($this->carBrandRepository->getCarBrandById($request->getBrandId()));
        }

        if (null !== $request->getLeftHandDrive()) {
            $car->setLeftHandDrive($request->getLeftHandDrive());
        }
        $this->carRepository->commit();
    }
    public function deleteCar(int $id): void
    {
        $car = $this->carRepository->getCarById($id);
        $this->carRepository->removeAndCommit($car);
    }
}
