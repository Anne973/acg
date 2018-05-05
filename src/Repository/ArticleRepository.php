<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
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

    public function search($query)
    {
        $qb = $this->createQueryBuilder('a');

        $words = explode(' ',$query);
        foreach($words as $key => $word){
            $qb->orWhere('a.title LIKE :word'.$key);
            $qb->orWhere('a.content LIKE :word'.$key);
            $qb->setParameter('word'.$key,'%'.$words[$key].'%');
        }

        return $qb->getQuery()->getResult();
    }

    public function getArticlesInHomepage()
    {
        $qb = $this->createQueryBuilder('a')
            ->setMaxResults(Article::ARTICLES_IN_HOMEPAGE)
            ->orderBy('a.id', 'desc');

        return $qb->getQuery()->getResult();
    }

    public function getArticles($page, $nbPerPage)

    {
        $queryBuilder = $this->createQueryBuilder('a')
            ->orderBy('a.id', 'desc');
        $query = $queryBuilder->getQuery();
        $query
            ->setFirstResult(($page - 1) * $nbPerPage)
            ->setMaxResults($nbPerPage);
        return new Paginator($query, true);
    }
//    /**
//     * @return Article[] Returns an array of Article objects
//     */
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
