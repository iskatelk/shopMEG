<?php

namespace App\Repository;

use App\Entity\Products;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Products>
 *
 * @method Products|null find($id, $lockMode = null, $lockVersion = null)
 * @method Products|null findOneBy(array $criteria, array $orderBy = null)
 * @method Products[]    findAll()
 * @method Products[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Products::class);
    }

    public function save(Products $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Products $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findProductPrice ()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.price','DESC')
            ->getQuery()
            ->getResult();

    }

    public function findProductMix ($value1,$value2,$value3,$value4,$value5)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.price > :val1')
            ->andWhere('a.price < :val2')
            ->andWhere('a.seller = :val3')
            ->andWhere('a.title = :val4')
            ->andWhere('a.model = :val5')
            ->setParameter('val1', $value1)
            ->setParameter('val2', $value2)
            ->setParameter('val3', $value3)
            ->setParameter('val4', $value4)
            ->setParameter('val5', $value5)
            ->getQuery()
            ->getResult();

    }

    public function findSelectProduct ($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.product_id = :val')
            ->setParameter('val', $value)
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();

    }


    public function getPriceItem($value) {
        return $this->createQueryBuilder('a')
            ->select('a.price')
            ->andWhere('a.product_id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult();
    }

    public function searchByQuery(string $query)
    {
        return $this->createQueryBuilder('p')
            ->where('p.title LIKE :query')
            ->setParameter('query', '%'. $query. '%')
            ->getQuery()
            ->getResult();
    }
//    /**
//     * @return Products[] Returns an array of Products objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Products
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
