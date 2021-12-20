<?php

namespace App\Repository;

use App\Entity\User;
use App\Services\HandlerQuery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $page = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public const USERS_PER_PAGE = 3;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getUserPaginator(int $page): Paginator
    {
        $handlerQuery = new HandlerQuery();

        $query = $handlerQuery->createQuery($this, 'u', self::USERS_PER_PAGE, $page);

        return new Paginator($query);
    }
}
