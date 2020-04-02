<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * FortuneCookieRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FortuneCookieRepository extends EntityRepository
{
public function countNumberPrintedForCategory(Category $category)
{
    $this->createQueryBuilder('fc')
        ->andWhere('fc.category = :category')
        ->setParameter('category', $category)
        ->select('SUM(fc.numberPrinted) as fortunesPrinted')
        ->getQuery()
//        ->getOneOrNullResult();
        ->getSingleScalarResult();

}
}
