<?php
namespace NewBundle\Service;

use NewBundle\Entity\College;
use NewBundle\Repository\CollegeRepository;
use NewBundle\Service\Response\CollegeDetailsResponse;

class CollegeService
{
    /**
     * @var CollegeRepository
     */
    private $collegeRepo;

    /**
     * @param CollegeRepository $collegeRepo
     */
    public function __construct(CollegeRepository $collegeRepo)
    {
        $this->collegeRepo = $collegeRepo;
    }

    /**
     * @return College[]
     */
    public function getAllColleges()
    {
        return $this->collegeRepo->findAll();
    }

    /**
     * @param College $college
     * @return CollegeDetailsResponse
     */
    public function getCollegeDetails(College $college)
    {
        $avg = $this->collegeRepo->getAvgStatistics($college);
        $studentsCount = $this->collegeRepo->getStudentsCount($college);

        return new CollegeDetailsResponse($college, $avg, $studentsCount);
    }
}