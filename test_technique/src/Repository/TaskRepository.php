<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    // /**
    //  * @return Task[] Returns an array of Task objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Task
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getAllTaskDone()
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.done = :val')
            ->setParameter('val', 1)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getAllFilterTaskDone($filter)
    {
        return $this->createQueryBuilder('t')
            ->innerJoin('t.project','p')
            ->andWhere('p.name LIKE :val OR t.startDate LIKE :val OR t.endDate LIKE :val OR t.title LIKE :val')
            ->andWhere('t.done = 1')
            ->setParameter('val', '%'.$filter.'%')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findWithFilter($filter)
    {
        return $this->createQueryBuilder('t')
            ->innerJoin('t.project','p')
            ->andWhere('p.name LIKE :val OR t.startDate LIKE :val OR t.endDate LIKE :val OR t.title LIKE :val')
            ->setParameter('val', '%'.$filter.'%')
            ->getQuery()
            ->getResult();
    }
}
