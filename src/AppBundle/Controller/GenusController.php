<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class GenusController extends Controller
{
    /**
     * @Route("/genus/{genusName}")
     * @param string $genusName
     *
     * @return Response
     */
    public function showAction(string $genusName)
    {
        $notes = [
            'Octopus asked me a riddle',
            'line 2',
            'line 3'
        ];
        return $this->render('genus/show.html.twig',
            [
                'name' => $genusName,
                'notes' => $notes
            ]
        );
    }
}