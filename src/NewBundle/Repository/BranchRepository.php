<?php
namespace NewBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use NewBundle\Entity\Branch;
use NewBundle\Entity\StudentLesson;

class BranchRepository extends EntityRepository
{
    /**
     * @param Branch $branch
     * @return float
     */
    public function getAvgStatistic(Branch $branch)
    {
        $qb = $this->createQueryBuilder('b');

        $qb
            ->select('AVG(sl.mark) AS mark')
            ->leftJoin('b.parties', 'p')
            ->leftJoin('p.students', 's')
            ->leftJoin(StudentLesson::class, 'sl', Join::WITH, 's.id = sl.student')
            ->where($qb->expr()->isNotNull('sl.mark'))
            ->andWhere('b.id = :branch_id')
            ->setParameter('branch_id', $branch->getId());

        return $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * @param Branch $branch
     * @return int
     */
    public function getStudentCount(Branch $branch)
    {
        $qb = $this->createQueryBuilder('b');

        $qb
            ->select($qb->expr()->count('s'))
            ->leftJoin('b.parties', 'p')
            ->leftJoin('p.students', 's')
            ->where('b.id = :branch_id')
            ->groupBy('b.id')
            ->setParameter('branch_id', $branch->getId());

        return $qb->getQuery()->getSingleScalarResult();
    }
}