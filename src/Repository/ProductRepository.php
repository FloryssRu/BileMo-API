<?php

namespace App\Repository;

use App\Entity\Product;
use App\Services\HandlerQuery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $page = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public const PRODUCTS_PER_PAGE = 5;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function getProductPaginator(int $page): Paginator
    {
        $handlerQuery = new HandlerQuery();
        
        $query = $handlerQuery->createQuery($this, 'p', self::PRODUCTS_PER_PAGE, $page);
        // $query = $this->createQueryBuilder('p')
        //     ->orderBy('p.createdAt', 'DESC')
        //     ->setMaxResults(self::PRODUCTS_PER_PAGE)
        //     ->setFirstResult(($page - 1) * self::PRODUCTS_PER_PAGE)
        //     ->getQuery()
        // ;

        return new Paginator($query);
    }
}
