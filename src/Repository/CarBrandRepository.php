<?php

namespace App\Repository;

use App\Entity\CarBrand;
use App\Exception\CarBrandNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CarBrand>
 */
class CarBrandRepository extends ServiceEntityRepository
{
    use RepositoryModifyTrait;
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarBrand::class);
    }

    public function findAllSortedByName(): array
    {
        return $this->findBy([], ['name' => Criteria::ASC]);
    }

    public function getCarBrandById(int $id): CarBrand
    {
        $carBrand = $this->find($id);
        if (null == $carBrand) {
            throw new CarBrandNotFoundException();
        }

        return $carBrand;
    }

    public function existsByName(string $name): bool
    {
        return null !== $this->findOneBy(['name' => $name]);
    }

    //    /**
    //     * @return CarBrand[] Returns an array of CarBrand objects
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

    //    public function findOneBySomeField($value): ?CarBrand
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
