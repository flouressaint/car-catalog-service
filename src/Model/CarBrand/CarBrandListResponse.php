<?php

declare(strict_types=1);

namespace App\Model\CarBrand;

class CarBrandListResponse
{
    /**
     * @param CarBrandListItem[] $items
     */
    public function __construct(
        private readonly array $items
    ) {
    }

    /**
     * @return CarBrandListItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
