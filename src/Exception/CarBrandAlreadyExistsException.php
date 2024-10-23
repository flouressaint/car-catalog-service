<?php

declare(strict_types=1);

namespace App\Exception;

class CarBrandAlreadyExistsException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Car brand already exists with this name');
    }
}
