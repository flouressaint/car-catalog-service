<?php

namespace App\DataFixtures;

use App\Entity\Car;
use App\Entity\CarBrand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CarBrandFixtures extends Fixture
{
    final public const CAR_BRANDS = [
        'Toyota',
        'Volkswagen',
        'Porsche',
        'BMW',
        'Nissan',
        'Mazda',
        'Audi',
        'Opel',
        'Mercedes'
    ];

    public function load(ObjectManager $manager): void
    {
        $carBrands = array_combine(self::CAR_BRANDS, array_map(
            fn (string $carBrandName) => (new CarBrand())->setName($carBrandName),
            self::CAR_BRANDS
        ));

        foreach ($carBrands as $carBrand) {
            $manager->persist($carBrand);
        }

        $manager->flush();

        foreach ($carBrands as $code => $carBrand) {
            $this->addReference($code, $carBrand);
        }
    }
}
