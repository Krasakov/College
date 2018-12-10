<?php
namespace NewBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use NewBundle\Entity\College;
use NewBundle\Entity\Student;
use NewBundle\Entity\StudentLesson;

class CollegeRepository extends EntityRepository
{
    /**
     * @param College $college
     * @return float
     */
    public function getAvgStatistics(College $college)
    {
        $qb = $this->createQueryBuilder('c');

        $qb
            ->select('AVG(sl.mark) AS mark')
            ->leftJoin('c.branches', 'b')
            ->leftJoin('b.parties', 'p')
            ->leftJoin('p.students', 's')
            ->leftJoin(StudentLesson::class, 'sl', Join::WITH, 's.id = sl.student')
            ->where($qb->expr()->isNotNull('sl.mark'))
            ->andWhere('c.id = :college_id')
            ->groupBy('c.id')
            ->setParameter('college_id', $college->getId());

        return $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * @param College $college
     * @return int
     */
    public function getStudentsCount(College $college)
    {
        $qb = $this->createQueryBuilder('c');

        $qb
            ->select($qb->expr()->count('s'))
            ->leftJoin('c.branches', 'b')
            ->leftJoin('b.parties', 'p')
            ->leftJoin('p.students', 's')
            ->where('c.id = :college_id')
            ->groupBy('c.id')
            ->setParameter('college_id', $college->getId());

        return $qb->getQuery()->getSingleScalarResult();
    }
}
