<?php

namespace App\Repository;

use App\Entity\Car;
use App\Exception\CarNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Car>
 */
class CarRepository extends ServiceEntityRepository
{
    use RepositoryModifyTrait;
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
    }

    public function exists($brandId, $model, $leftHandDrive): bool
    {
        return $this->createQueryBuilder("c")
        ->andWhere("c.brand = :brandId")
        ->andWhere("c.model = :model")
        ->andWhere("c.leftHandDrive = :leftHandDrive")
        ->setParameter("brandId", $brandId)
        ->setParameter("model", $model)
        ->setParameter("leftHandDrive", $leftHandDrive)
        ->getQuery()
        ->getOneOrNullResult() !== null;
    }

    public function getCarById(int $id): Car
    {
        $car = $this->find($id);
        if (null == $car) {
            throw new CarNotFoundException();
        }

        return $car;
    }

    //    /**
    //     * @return Car[] Returns an array of Car objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Car
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
