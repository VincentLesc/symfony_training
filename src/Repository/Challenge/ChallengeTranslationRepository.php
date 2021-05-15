<?php

namespace App\Repository\Challenge;

use App\Entity\Challenge\Challenge;
use App\Entity\Challenge\ChallengeTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ChallengeTranslation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChallengeTranslation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChallengeTranslation[]    findAll()
 * @method ChallengeTranslation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChallengeTranslationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChallengeTranslation::class);
    }

    public function getLocalesByChallenge(Challenge $challenge)
    {
        return $this->createQueryBuilder('c')
        ->select('c.locale')
        ->where('c.challenge = :challenge')
        ->setParameter(':challenge', $challenge)
        ->getQuery()
        ->getResult();
    }

    // /**
    //  * @return ChallengeTranslation[] Returns an array of ChallengeTranslation objects
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
    public function findOneBySomeField($value): ?ChallengeTranslation
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
