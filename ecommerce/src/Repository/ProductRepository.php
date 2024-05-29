<?php

// src/Repository/ProductRepository.php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findBySearchAndCategory($search, $category)
    {
        $qb = $this->createQueryBuilder('p')
            ->where('p.name LIKE :search')
            ->orWhere('p.description LIKE :search')
            ->setParameter('search', '%' . $search . '%');

        if ($category) {
            $qb->andWhere('p.category = :category')
               ->setParameter('category', $category);
        }

        return $qb->getQuery()->getResult();
    }
}
