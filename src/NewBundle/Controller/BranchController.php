<?php
namespace NewBundle\Controller;

use NewBundle\Entity\Branch;
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
        $avg = $this->get('new.service.branch_service')->getAvgStudents($branch);
        $studentCount = $this->get('new.service.branch_service')->getStudentCount($branch);
        $topStudents = $this->get('new.service.branch_service')->getTopStudent($branch);

        return $this->render('@New/branches/details.html.twig', [
            'branch' => $branch,
            'avg' => $avg,
            'studentCount' => $studentCount,
            'tops' => $topStudents
        ]);
    }
}