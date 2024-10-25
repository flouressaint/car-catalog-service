<?php

namespace App\DataFixtures;

use App\DataFixtures\CarBrandFixtures;
use App\Entity\Car;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CarFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $car = (new Car())
            ->setBrand($this->getReference(CarBrandFixtures::CAR_BRANDS[array_rand(CarBrandFixtures::CAR_BRANDS)]))
            ->setModel('Model '.$i)
            ->setLeftHandDrive(random_int(0, 1) === 1);
            $manager->persist($car);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CarBrandFixtures::class,
        ];
    }
}
