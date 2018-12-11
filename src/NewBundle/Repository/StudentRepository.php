<?php
namespace NewBundle\Repository;

use Doctrine\ORM\EntityRepository;
use NewBundle\Entity\Branch;

class StudentRepository extends EntityRepository
{
    /**
     * @param Branch $branch
     * @return array
     */
    public function getTopStudents(Branch $branch)
    {
        $conn = $this->getEntityManager()->getConnection();
        $stmt = $conn
            ->prepare('
                SELECT
                    s.id AS id, s.name AS name, avg(sl.mark) AS avg_mark
                FROM
                    student AS s
                LEFT JOIN student_lesson AS sl ON sl.student_id = s.id
                LEFT JOIN party AS p ON s.party_id = p.id
                LEFT JOIN branch AS b ON p.branch_id = b.id
                WHERE 
                    b.id = :branch_id
                    AND 
                    sl.mark IS NOT NULL 
                GROUP BY s.id
                HAVING avg_mark = (
                          SELECT 
                              max(u.avg_mark)
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
                                  br.id = :branch_id
                                  AND sle.mark IS NOT NULL
                              GROUP BY st.id
                        ) AS u
                )
            ');
        $stmt->bindValue('branch_id', $branch->getId());

        $stmt->execute();

        return $stmt->fetchAll();
    }
}