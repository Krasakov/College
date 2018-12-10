<?php

namespace NewBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="party")
 */
class Party
{
    /**
     * @var integer
     *
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @var Branch
     *
     * @ORM\ManyToOne(targetEntity="NewBundle\Entity\Branch", inversedBy="parties")
     * @ORM\JoinColumn(name="branch_id", referencedColumnName="id")
     */
    private $branch;

    /**
     * @var Collection|Student[]
     *
     * @ORM\OneToMany(targetEntity="NewBundle\Entity\Student", mappedBy="party")
     */
    private $students;

    public function __construct()
    {
        $this->students = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return Branch
     */
    public function getBranch()
    {
        return $this->branch;
    }

    /**
     * @param Branch $branch
     */
    public function setBranch(Branch $branch)
    {
        $this->branch = $branch;
    }

    /**
     * @return Collection|Student[]
     */
    public function getStudents()
    {
        return $this->students;
    }

    /**
     * @param Student[] $students
     * @return Party
     *
     */
    public function setStudents(array $students)
    {
        $this->students = $students;

        return $this;
    }

}