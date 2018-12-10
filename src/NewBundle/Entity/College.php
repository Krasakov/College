<?php

namespace NewBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="NewBundle\Repository\CollegeRepository")
 * @ORM\Table(name="college")
 */
class College
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
     * @var Collection|Branch[]
     *
     * @ORM\OneToMany(targetEntity="NewBundle\Entity\Branch", mappedBy="college")
     */
    private $branches;

    public function __construct()
    {
        $this->branches = new ArrayCollection();
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
     * @return Collection|Branch[]
     */
    public function getBranches()
    {
        return $this->branches;
    }

    /**
     * @param Branch[] $branches
     * @return College
     */
    public function setBranches(array $branches)
    {
        $this->branches = new ArrayCollection($branches);

        return $this;
    }
}