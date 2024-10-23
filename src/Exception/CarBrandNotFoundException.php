<?php

declare(strict_types=1);

namespace App\Exception;

class CarBrandNotFoundException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Car brand not found');
    }
}
