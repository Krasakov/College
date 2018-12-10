<?php
namespace NewBundle\Service\Response;

use NewBundle\Entity\College;

class CollegeDetailsResponse
{
    /**
     * @var College
     */
    private $college;

    /**
     * @var float
     */
    private $avg;

    /**
     * @var int
     */
    private $studentsCount;

    /**
     * @param College $college
     * @param float $avg
     * @param int $studentsCount
     */
    public function __construct(College $college, $avg, $studentsCount)
    {
        $this->college = $college;
        $this->avg = $avg;
        $this->studentsCount = $studentsCount;
    }

    /**
     * @return College
     */
    public function getCollege()
    {
        return $this->college;
    }

    /**
     * @return float
     */
    public function getAvg()
    {
        return $this->avg;
    }

    /**
     * @return int
     */
    public function getStudentsCount()
    {
        return $this->studentsCount;
    }
}