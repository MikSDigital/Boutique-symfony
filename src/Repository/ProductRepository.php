<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Product::class);
    }


    /**
     * @return Product|null
     * @throws \Exception
     */
    public function findByThreeProduct()
    {
        $query = $this->createQueryBuilder('p')
            ->select('p')
            ->orderBy('p.createdAt', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
        ;

        try {
            return $query->getResult();
        }
        catch (\Exception $e) {
            throw new \Exception('Problème' . $e->getMessage(). $e->getFile(). $e->getLine(). $e->getCode());
        }
    }

    //SELECT * FROM product ORDER BY RAND() LIMIT 3
    /**
     * @return Product|null
     * @throws \Exception
     */
    public function findBySlider()
    {

        $query = $this->createQueryBuilder('p')
            ->select('p')
            ->orderBy('RAND()', 'DESC')
            ->setMaxResults(3)
            ->getQuery();

        try {
            return $query->getResult();
        }
        catch (\Exception $e) {
            throw new \Exception('Problème' . $e->getMessage(). $e->getFile(). $e->getLine(). $e->getCode());
        }
    }

    /**
     * @return Product|null
     * @throws \Exception
     */
    public function findProductByCategory() {

        $query = $this->createQueryBuilder('p')
        ->select('p')
        ->orderBy('RAND()', 'ASC')
        ->setMaxResults(8)
        ->getQuery()
        ;

        try {
            return $query->getResult();
        }
        catch (\Exception $e) {
            throw new \Exception('Problème' . $e->getMessage(). $e->getFile(). $e->getLine(). $e->getCode());
        }
    }

}
