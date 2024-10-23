<?php

declare(strict_types=1);

namespace App\Exception;

class CarAlreadyExistsException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('This car model already exists');
    }
}
