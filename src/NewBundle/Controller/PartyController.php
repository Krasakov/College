<?php
namespace NewBundle\Controller;

use NewBundle\Entity\Party;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PartyController extends Controller
{
    /**
     * @Route(path="/party/details/{id}", methods={"get"}, name="party_details")
     *
     * @param Party $party
     * @return Response
     */
    public function detailsAction(Party $party)
    {
        return $this->render('@New/party/details.html.twig', [
            'party' => $party
        ]);
    }
}