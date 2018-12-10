<?php
namespace NewBundle\Service;

use NewBundle\Entity\Branch;
use NewBundle\Repository\BranchRepository;

class BranchService
{
    /**
     * @var BranchRepository
     */
    private $brunchRepo;

    /**
     * @param BranchRepository $branchRepo
     */
    public function __construct(BranchRepository $branchRepo)
    {
        $this->brunchRepo = $branchRepo;
    }

    /**
     * @param Branch $branch
     * @return float
     */
    public function getAvgStudents(Branch $branch)
    {
        return $this->brunchRepo->getAvgStatistic($branch);
    }

    /**
     * @param Branch $branch
     * @return int
     */
    public function getStudentCount(Branch $branch)
    {
        return $this->brunchRepo->getStudentCount($branch);
    }

    /**
     * @param Branch $branch
     * @return array
     */
    public function getTopStudent(Branch $branch)
    {
        return $this->brunchRepo->getTopStudent($branch);
    }
}