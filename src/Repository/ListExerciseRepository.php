<?php

namespace App\Repository;

use App\Entity\ListExercise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ListExercise|null find($id, $lockMode = null, $lockVersion = null)
 * @method ListExercise|null findOneBy(array $criteria, array $orderBy = null)
 * @method ListExercise[]    findAll()
 * @method ListExercise[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListExerciseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ListExercise::class);
    }

    // /**
    //  * @return ListExercise[] Returns an array of ListExercise objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ListExercise
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
