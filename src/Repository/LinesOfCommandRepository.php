<?php

namespace App\Repository;

use App\Entity\LinesOfCommand;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method LinesOfCommand|null find($id, $lockMode = null, $lockVersion = null)
 * @method LinesOfCommand|null findOneBy(array $criteria, array $orderBy = null)
 * @method LinesOfCommand[]    findAll()
 * @method LinesOfCommand[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LinesOfCommandRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, LinesOfCommand::class);
    }

//    /**
//     * @return LinesOfCommand[] Returns an array of LinesOfCommand objects
//     */
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
    public function findOneBySomeField($value): ?LinesOfCommand
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
