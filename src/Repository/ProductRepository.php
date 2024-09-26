<?php

namespace App\Repository;

use App\Filter\Search;
use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    const ITEMS_PER_PAGE = 3;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    //    /**
    //     * @return Product[] Returns an array of Product objects
    //     */
    public function findBySearchFilter(Search $search, $offset): Paginator
    {
        $query = $this->createQueryBuilder('p')
            ->leftJoin('p.category', 'c');
        if (!empty($search->searchCategories)) {
            $query = $query->andwhere('c.id in (:categories)')
                ->setParameter('categories', $search->searchCategories);
        }
        $name = $search->searchname;

        if (isset($name)) {
            $query = $query->andWhere('p.name LIKE :searchname')
                ->setParameter('searchname', "%$name%");
        }
        $query = $query->orderBy('p.name', 'ASC')
            ->setMaxResults(self::ITEMS_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery();
            // ->getResult();
        return new Paginator($query);
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
