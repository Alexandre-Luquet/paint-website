<?php

namespace App\Repository;

use App\Entity\Biographie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Biographie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Biographie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Biographie[]    findAll()
 * @method Biographie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BiographieRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Biographie::class);
    }

    /**
     * @return Biographie  Retourne la biographie avec le plus haut numéro d'id ou null
     */
    public function findLastId()
    {
        $arrayLastIdent =  $this->createQueryBuilder('b')
            ->orderBy('b.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
            ;
        if (isset($arrayLastIdent[0])) {
            return $arrayLastIdent[0];
        } else {
            return null;
        }
    }


    // /**
    //  * @return Biographie[] Returns an array of Biographie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Biographie
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
