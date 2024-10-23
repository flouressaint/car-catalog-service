<?php

declare(strict_types=1);

namespace App\Model\CarBrand;

use Symfony\Component\Validator\Constraints as Assert;

class CreateCarBrandRequest
{
    #[Assert\NotBlank(message: 'Car brand name is required.')]
    private string $name;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
