<?php

namespace App\Repository\Challenge;

use App\Entity\Challenge\Challenge;
use App\Entity\Challenge\ChallengeTranslation;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Challenge|null find($id, $lockMode = null, $lockVersion = null)
 * @method Challenge|null findOneBy(array $criteria, array $orderBy = null)
 * @method Challenge[]    findAll()
 * @method Challenge[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChallengeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Challenge::class);
    }

    public function findAllChallengesByLocale(string $locale)
    {
        return $this->createQueryBuilder('c')
            ->join('c.challengeTranslations', 'ct')
            ->addSelect('ct')
            ->addSelect('CASE WHEN c.state > 50 THEN 2 ELSE (CASE WHEN c.state >=20 THEN 3 ELSE 1 END) END AS HIDDEN ord')
            ->where('ct.locale = :locale')
            ->andWhere('ct.state = :published')
            ->andWhere('c.state < 70')
            ->andWhere('c.state > 10')
            ->setParameter(':locale', $locale)
            ->setParameter(':published', ChallengeTranslation::PUBLISHED)
            ->orderBy('ord', 'DESC')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Challenge[] Returns an array of Challenge objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Challenge
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
