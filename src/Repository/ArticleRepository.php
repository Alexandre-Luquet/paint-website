<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function search(array $filters =[])
    {
        // constructeur de requete SQL
        // le 'a' est l'alias de la table article dans la requete
        $qb = $this->createQueryBuilder('a');

        // tris par date decroissant
        $qb->orderBy('a.datePublication', 'DESC');

        if (!empty($filters['titre'])){
            $qb
                ->andWhere('a.titre LIKE :titre')
                ->setParameter('titre', '%' . $filters['titre'] . '%');
        }

        if (!empty($filters['start_date'])){
            $qb
                ->andWhere('a.datePublication LIKE >= :start_date')
                ->setParameter('start_date', '%' . $filters['start_date'] . '%');
        }

        if (!empty($filters['end_date'])){
            $qb
                ->andWhere('a.datePublication LIKE <= :end_date')
                ->setParameter('end_date', '%' . $filters['end_date'] . '%');
        }

        if (!empty($filters['category'])){
            $qb
                ->andWhere('a.category = :category')
                ->setParameter('category', $filters['category']);
        }

        // requete generee
        $query = $qb->getQuery();

        // on retourne le resultat
        return $query->getResult();
    }
    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
