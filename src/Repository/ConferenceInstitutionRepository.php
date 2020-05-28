<?php

namespace App\Repository;

use App\Entity\ConferenceInstitution;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ConferenceInstitution|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConferenceInstitution|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConferenceInstitution[]    findAll()
 * @method ConferenceInstitution[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConferenceInstitutionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConferenceInstitution::class);
    }

    // /**
    //  * @return ConferenceInstitution[] Returns an array of ConferenceInstitution objects
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
    public function findOneBySomeField($value): ?ConferenceInstitution
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
