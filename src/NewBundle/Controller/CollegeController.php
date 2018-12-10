<?php
namespace NewBundle\Controller;

use NewBundle\Entity\College;
use NewBundle\Service\CollegeService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CollegeController extends Controller
{
    /**
     * @Route(path="/", methods={"get"}, name="college_list")
     *
     * @return Response
     */
    public function listAction()
    {
        $colleges = $this->getService()->getAllColleges();

        return $this->render('@New/colleges/college.html.twig', [
            'colleges' => $colleges
        ]);
    }

    /**
     * @Route(path="/college/details/{id}", methods={"get"}, name="college_details")
     *
     * @param College $college
     * @return Response
     */
    public function detailsAction(College $college)
    {
        $responseData = $this->getService()->getCollegeDetails($college);

        return $this->render('@New/colleges/details.html.twig', [
            'data' => $responseData,
        ]);
    }

    /**
     * @return CollegeService|object
     */
    private function getService()
    {
        return $this->get('new.service.college_service');
    }
}