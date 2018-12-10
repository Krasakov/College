<?php
namespace NewBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use NewBundle\Entity\Branch;
use NewBundle\Entity\Student;
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

    /**
     * @param Branch $branch
     * @return array
     */
    public function getTopStudent(Branch $branch)
    {
        $conn = $this->getEntityManager()->getConnection();
        $stmt = $conn
            ->prepare('
                SELECT 
                    s.id AS id, s.name AS name, avg(sl.mark) AS avg_mark
                FROM
                    student AS s
                LEFT JOIN
                    student_lesson AS sl ON sl.student_id = s.id
                LEFT JOIN party AS p ON s.party_id = p.id
                LEFT JOIN branch AS b ON p.branch_id = b.id
                WHERE
                    b.id = :brunch_id
                    AND sl.mark IS NOT NULL
                GROUP BY s.id
                HAVING 
                    avg_mark = (
                        SELECT 
                            MAX(u.avg_mark) 
                        FROM (
                            SELECT 
                                avg(sle.mark) AS avg_mark
                            FROM
                                student AS st
                            LEFT JOIN
                                student_lesson AS sle ON sle.student_id = st.id
                            LEFT JOIN party AS pa ON st.party_id = pa.id
                            LEFT JOIN branch AS br ON pa.branch_id = br.id
                            WHERE
                                br.id = :brunch_id
                                AND sle.mark IS NOT NULL
                            GROUP BY st.id
                        ) as u
                    )
            ');
        $stmt->bindValue(':brunch_id', $branch->getId());

        $stmt->execute();

        return $stmt->fetchAll();
    }
}