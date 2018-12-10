<?php

namespace NewBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="NewBundle\Repository\BranchRepository")
 * @ORM\Table(name="branch")
 */
class Branch
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
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $description;

    /**
     * @var College
     *
     * @ORM\ManyToOne(targetEntity="NewBundle\Entity\College", inversedBy="branches")
     * @ORM\JoinColumn(name="college_id", referencedColumnName="id")
     */
    private $college;

    /**
     * @var BranchHead
     *
     * @ORM\OneToOne(targetEntity="NewBundle\Entity\BranchHead")
     * @ORM\JoinColumn(name="branch_head_id", referencedColumnName="id")
     */
    private $branchHead;

    /**
     * @var Collection|Party[]
     *
     * @ORM\OneToMany(targetEntity="NewBundle\Entity\Party", mappedBy="branch")
     */
    private $parties;

    public function __construct()
    {
        $this->parties = new ArrayCollection();
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
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return College
     */
    public function getCollege()
    {
        return $this->college;
    }

    /**
     * @param College $college
     */
    public function setCollege(College $college)
    {
        $this->college = $college;
    }

    /**
     * @return BranchHead
     */
    public function getBranchHead()
    {
        return $this->branchHead;
    }

    /**
     * @param BranchHead $branchHead
     */
    public function setBranchHead(BranchHead $branchHead)
    {
        $this->branchHead = $branchHead;
    }

    /**
     * @return Collection|Party[]
     */
    public function getParties()
    {
        return $this->parties;
    }

    /**
     * @param Party[] $parties
     * @return Branch
     */
    public function setParties(array $parties)
    {
        $this->parties = $parties;

        return $this;
    }
}
