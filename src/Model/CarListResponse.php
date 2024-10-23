<?php

declare(strict_types=1);

namespace App\Model;

class CarListResponse
{
    /**
     * @param CarListItem[] $items
     */
    public function __construct(
        private readonly array $items
    ) {
    }

    /**
     * @return CarListItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
