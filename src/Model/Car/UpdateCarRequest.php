<?php

declare(strict_types=1);

namespace App\Model\Car;

use Symfony\Component\Validator\Constraints as Assert;

class UpdateCarRequest
{
    #[Assert\NotBlank(message: 'Model cannot be empty')]
    private string $model;
    #[Assert\NotBlank(message: 'Brand id cannot be empty')]
    private int $brandId;
    private bool $leftHandDrive = true;


    public function getModel(): string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getBrandId(): int
    {
        return $this->brandId;
    }

    public function setBrandId(int $brandId): self
    {
        $this->brandId = $brandId;

        return $this;
    }

    public function getLeftHandDrive(): bool
    {
        return $this->leftHandDrive;
    }

    public function setLeftHandDrive(bool $leftHandDrive): self
    {
        $this->leftHandDrive = $leftHandDrive;

        return $this;
    }
}
