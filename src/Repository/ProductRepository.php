<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function save(Product $product, bool $andFlush = false): void
    {
        $em = $this->getEntityManager();
        $em->persist($product);
        $andFlush && $em->flush();
    }

    /**
     * @return Product[] Returns an array of Product objects
     */
    public function findAllSorted(): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Product[] Returns an array of Product objects
     */
    public function findActive(): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.active = 1')
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    //    public function findOneBySomeField($value): ?Product
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
