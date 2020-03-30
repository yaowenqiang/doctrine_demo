<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryRepository extends EntityRepository
{
    public function findAllOrdered()
    {
//        $dql = "select cat from AppBundle\Entity\Category cat order  by cat.name desc";

        $qb = $this->createQueryBuilder('cat')
            ->addOrderBy('cat.name', 'DESC');

        $query = $qb->getQuery();
//        var_dump($query->getDQL());




//        $query = $this->getEntityManager()->createQuery($dql);
//        var_dump($query->getSQL());

        return $query->execute();

    }

    public function search($term)
    {
        return $this->createQueryBuilder('cat')
//            ->andWhere('cat.name = :searchItem')
            ->andWhere('cat.name LIKE :searchItem OR cat.iconKey like :searchItem')
            ->setParameter('searchItem', '%' . $term . '%')
            ->getQuery()
            ->execute();
    }
}
