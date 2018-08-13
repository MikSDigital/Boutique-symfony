<?php

namespace App\Repository;

use App\Entity\RandomMessage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RandomMessage|null find($id, $lockMode = null, $lockVersion = null)
 * @method RandomMessage|null findOneBy(array $criteria, array $orderBy = null)
 * @method RandomMessage[]    findAll()
 * @method RandomMessage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RandomMessageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RandomMessage::class);
    }


    public function findByMessage()
    {
        $query = $this->createQueryBuilder('m')
            ->select('m')
            ->orderBy('RAND()', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
        ;

        try {
            return $query->getOneOrNullResult();
        }
        catch (\Exception $e) {
            throw new \Exception('Problème' . $e->getMessage(). $e->getFile(). $e->getLine(). $e->getCode());
        }
    }



}
