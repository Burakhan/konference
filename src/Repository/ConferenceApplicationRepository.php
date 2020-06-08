<?php

namespace App\Repository;

use App\Entity\ConferenceApplication;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ConferenceApplication|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConferenceApplication|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConferenceApplication[]    findAll()
 * @method ConferenceApplication[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConferenceApplicationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConferenceApplication::class);
    }

    // /**
    //  * @return ConferenceApplication[] Returns an array of ConferenceApplication objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ConferenceApplication
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
