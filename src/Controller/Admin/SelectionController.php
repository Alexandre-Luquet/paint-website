<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SelectionController extends AbstractController
{
    /**
     * @Route("/selection", name="selection")
     */
    public function index()
    {
        return $this->render('selection/index.html.twig', [
            'controller_name' => 'SelectionController',
        ]);
    }
}
