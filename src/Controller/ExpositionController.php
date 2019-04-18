<?php

namespace App\Controller;

use App\Entity\Exposition;
use App\Repository\ExpositionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/exposition")
 */
class ExpositionController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {
        $expositions = $this->getDoctrine()->getRepository(Exposition::class)->findAll();

        return $this->render('exposition/index.html.twig', [
            'controller_name' => 'ExpositionController',
            'expositions' => $expositions,
        ]);
    }

    /**
     * @Route("/{id}")
     */
    public function showExposition($id)
    {
        // Récupération d'une ligne de la table Exposition correspondant à l'id
        $exposition = $this->getDoctrine()->getRepository(Exposition::class)->find($id);

        // Message d'erreur si je n'ai pas trouvé la ligne, donc base non initialisée
        if (!$exposition) {
            throw $this->createNotFoundException(
                "Pas de tableau trouvé avec l'id  " . $id . " en base de données"
            );
        }

        return $this->render('exposition/exposition.html.twig', [
            'controller_name' => 'ExpositionController',
            'exposition' => $exposition,
        ]);

    }
}
