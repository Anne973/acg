<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function getEvents()
    {
        $qb = $this->createQueryBuilder('a')
            ->orderBy('a.date', 'asc')
            ->andWhere('a.date > :now')
            ->setParameter('now', new \DateTimeImmutable());

        return $qb->getQuery()->getResult();
    }

    public function getEventsInArticlePage()
    {
        $qb = $this->createQueryBuilder('a')

            ->orderBy('a.id', 'asc')
            ->andWhere('a.date > :now')
            ->setParameter('now', new \DateTimeImmutable())
            ->setMaxResults(Event::EVENTS_IN_ARTICLE_PAGE);
        return $qb->getQuery()->getResult();
    }

//    /**
//     * @return Event[] Returns an array of Event objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Event
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
