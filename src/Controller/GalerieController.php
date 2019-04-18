<?php

namespace App\Controller;

use App\Entity\Tableau;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GalerieController extends AbstractController
{
    /**
     * @Route("/galerie", name="galerie")
     */
    public function index()
    {

        $galerie = $this->getDoctrine()->getRepository(Tableau::class)->findAll();

        return $this->render('galerie/index.html.twig', [
            'controller_name' => 'GalerieController',
            'galerie' => $galerie,
        ]);
    }
}
