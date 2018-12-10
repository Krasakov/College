<?php

namespace NewBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="student_lesson")
 */
class StudentLesson
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int|null
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $mark;

    /**
     * @var Student
     *
     * @ORM\ManyToOne(targetEntity="NewBundle\Entity\Student")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id")
     */
    private $student;

    /**
     * @var Lesson
     *
     * @ORM\ManyToOne(targetEntity="NewBundle\Entity\Lesson")
     * @ORM\JoinColumn(name="lesson_id", referencedColumnName="id")
     */
    private $lesson;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getMark()
    {
        return $this->mark;
    }

    /**
     * @param int|null $mark
     */
    public function setMark($mark)
    {
        $this->validateMark($mark);
        $this->mark = $mark;
    }

    /**
     * @param int $mark
     */
    private function validateMark($mark)
    {
        if ($mark !== null && (!is_int($mark) || $mark < 1 || $mark > 10)) {
            throw new \InvalidArgumentException('Wrong mark');
        }
    }

    /**
     * @return Student
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * @param Student $student
     */
    public function setStudent(Student $student)
    {
        $this->student = $student;
    }

    /**
     * @return Lesson
     */
    public function getLesson()
    {
        return $this->lesson;
    }

    /**
     * @param Lesson $lesson
     */
    public function setLesson(Lesson $lesson)
    {
        $this->lesson = $lesson;
    }

}