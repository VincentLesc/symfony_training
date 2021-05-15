<?php

namespace App\Repository\Challenge;

use App\Entity\Challenge\ChallengeParticipationVote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ChallengeParticipationVote|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChallengeParticipationVote|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChallengeParticipationVote[]    findAll()
 * @method ChallengeParticipationVote[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChallengeParticipationVoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChallengeParticipationVote::class);
    }

    // /**
    //  * @return ChallengeParticipationVote[] Returns an array of ChallengeParticipationVote objects
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
    public function findOneBySomeField($value): ?ChallengeParticipationVote
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
