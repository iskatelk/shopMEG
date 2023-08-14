<?php

namespace App\Repository;

use App\Entity\HistoryView;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HistoryView>
 *
 * @method HistoryView|null find($id, $lockMode = null, $lockVersion = null)
 * @method HistoryView|null findOneBy(array $criteria, array $orderBy = null)
 * @method HistoryView[]    findAll()
 * @method HistoryView[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistoryViewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HistoryView::class);
    }

//    /**
//     * @return HistoryView[] Returns an array of HistoryView objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('h.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?HistoryView
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
