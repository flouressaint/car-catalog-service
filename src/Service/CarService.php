<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Car;
use App\Exception\CarAlreadyExistsException;
use App\Model\CarBrandListItem;
use App\Model\CarListItem;
use App\Model\CarListResponse;
use App\Model\CreateCarRequest;
use App\Model\IdResponse;
use App\Model\UpdateCarRequest;
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

    // public function getCar(int $id): CarListItem
    // {
    //     $car = $this->carRepository->getCarById($id);

    //     return new CarListItem($car->getId(), $car->getName());
    // }

    public function createCar(CreateCarRequest $request): IdResponse
    {
        if ($this->carRepository->exists($request->getBrandId(), $request->getModel(), $request->getLeftHandDrive())) {
            throw new \DomainException("Car {$request->getModel()} already exists");
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
        if ($this->carRepository->exists($request->getBrandId(), $request->getModel(), $request->getLeftHandDrive())) {
            throw new \DomainException("Car {$request->getModel()} already exists");
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
