<?php

namespace App\Services;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class HandlerQuery
{
    public function createQuery(ServiceEntityRepository $repository, string $table, int $numberPerPage, int $page)
    {
        return $repository->createQueryBuilder($table)
            ->orderBy($table . '.createdAt', 'DESC')
            ->setMaxResults($numberPerPage)
            ->setFirstResult(($page - 1) * $numberPerPage)
            ->getQuery()
        ;
    }
}