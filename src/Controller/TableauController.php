<?php

namespace App\Controller;

use App\Entity\Tableau;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tableau")
 */
class TableauController extends AbstractController
{
    /**
     * @Route("/all")
     */
    public function galerie()
    {
        $galerie = $this->getDoctrine()->getRepository(Tableau::class)->findAll();

        return $this->render('galerie/index.html.twig', [
            'controller_name' => 'GalerieController',
            'galerie' => $galerie,
        ]);

    }

}