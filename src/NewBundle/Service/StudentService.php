<?php
namespace NewBundle\Service;

use NewBundle\Entity\Branch;
use NewBundle\Repository\StudentRepository;

class StudentService
{
    /**
     * @var StudentRepository
     */
    private $studentRepo;

    /**
     * @param StudentRepository $studentRepo
     */
    public function __construct(StudentRepository $studentRepo)
    {
        $this->studentRepo = $studentRepo;
    }

    /**
     * @param Branch $branch
     * @return array
     */
    public function getTopStudents(Branch $branch)
    {
        return $this->studentRepo->getTopStudents($branch);
    }
}