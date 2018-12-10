<?php
namespace NewBundle\Command;

use NewBundle\Entity\Branch;
use NewBundle\Entity\BranchHead;
use NewBundle\Entity\College;
use NewBundle\Entity\Lesson;
use NewBundle\Entity\Party;
use NewBundle\Entity\Student;
use NewBundle\Entity\StudentLesson;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Faker;

class TestCommand extends ContainerAwareCommand
{
    protected static $defaultName = 'reset:db';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $command = $this->getApplication()->find('doctrine:database:drop');
        $input = new ArrayInput(['--force'  => true]);
        $command->run($input, $output);

        $command = $this->getApplication()->find('doctrine:database:create');
        $input = new ArrayInput([]);
        $command->run($input, $output);

        $command = $this->getApplication()->find('doctrine:schema:create');
        $input = new ArrayInput([]);
        $command->run($input, $output);

        $this->createData();
    }

    public function createData()
    {
        $faker = Faker\Factory::create();
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $lessons = [];
        for ($i = 0; $i < 5; $i++) {
            $lesson = new Lesson();
            $lesson->setTitle($faker->languageCode);
            $em->persist($lesson);
            $lessons[] = $lesson;
        }
        $lessonCount = count($lessons);

        for ($i = 0; $i < 2; $i++) {
            $college = new College();
            $college->setTitle($faker->company);
            $college->setDescription($faker->text(200));
            $em->persist($college);

            for ($b = 0; $b < 3; $b++) {
                $branchHead = new BranchHead();
                $branchHead->setFirstName($faker->firstName);
                $branchHead->setLastName($faker->lastName);
                $branchHead->setPhone($faker->phoneNumber);
                $em->persist($branchHead);
                $branch = new Branch();
                $branch->setTitle($faker->countryCode);
                $branch->setCollege($college);
                $branch->setDescription($faker->text(50));
                $branch->setBranchHead($branchHead);
                $em->persist($branch);

                for ($x = 0; $x < 3; $x++) {
                    $party = new Party();
                    $party->setTitle($faker->swiftBicNumber);
                    $party->setBranch($branch);
                    $em->persist($party);

                    for ($p = 0; $p < $lessonCount; $p++) {
                        $lesson = $lessons[$p];
                        $lessonTimes = $faker->randomDigitNotNull;
                        for ($y = 0; $y < 5; $y++) {
                            $student = new Student();
                            $student->setName($faker->name);
                            $student->setParty($party);
                            $student->setAge($faker->numberBetween(17, 24));
                            $em->persist($student);
                            for ($k = 0; $k < $lessonTimes; $k++) {
                                $studentLesson = new StudentLesson();
                                $studentLesson->setStudent($student);
                                $studentLesson->setLesson($lesson);
                                $studentLesson->setMark(
                                    $faker->boolean(30)
                                        ? $faker->numberBetween(1, 10)
                                        : null
                                );
                                $em->persist($studentLesson);
                            }
                        }
                    }
                }
            }
        }

        $em->flush();
    }
}