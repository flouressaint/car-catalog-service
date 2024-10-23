<?php

declare(strict_types=1);

namespace App\Model;

class CarListItem
{
    public function __construct(
        private int $id,
        private string $model,
        private CarBrandListItem $brand,
        private bool $leftHandDrive,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function getBrand(): CarBrandListItem
    {
        return $this->brand;
    }

    public function getLeftHandDrive(): bool
    {
        return $this->leftHandDrive;
    }
}
