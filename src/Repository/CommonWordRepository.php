<?php

namespace App\Repository;

use App\Entity\CommonWord;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CommonWord|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommonWord|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommonWord[]    findAll()
 * @method CommonWord[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommonWordRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommonWord::class);
    }

    /**
     * Returns $limit common words from database
     * @param int|null $limit
     * @return array
     */
    public function getWordsSortedByRank(int $limit = null)
    {
        $qb = $this->createQueryBuilder('c')
            ->select('c.word')
            ->orderBy('c.rank', 'ASC');
        if (null !== $limit) {
            $qb->setMaxResults($limit);
        }
        $res = $qb->getQuery()->getArrayResult();

        return array_column($res, 'word');
    }

    /*
    public function findOneBySomeField($value): ?CommonWord
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
