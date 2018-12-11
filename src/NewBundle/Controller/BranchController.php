<?php
namespace NewBundle\Controller;

use NewBundle\Entity\Branch;
use NewBundle\Service\BranchService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BranchController extends Controller
{
    /**
     * @Route(path="/branches/details/{id}", methods={"get"}, name="branch_details")
     *
     * @param Branch $branch
     * @return Response
     */
    public function detailsAction(Branch $branch)
    {
        $avg = $this->getService()->getAvgStudents($branch);
        $studentCount = $this->getService()->getStudentCount($branch);
        $topStudents = $this->getService()->getTopStudents($branch);

        return $this->render('@New/branches/details.html.twig', [
            'branch' => $branch,
            'avg' => $avg,
            'studentCount' => $studentCount,
            'tops' => $topStudents
        ]);
    }

    /**
     * @return BranchService|object
     */
    public function getService()
    {
        return $this->get('new.service.branch_service');
    }
}