<?php

namespace App\Controller;

use App\Entity\Tableau;
use App\Repository\TableauRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

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

    /**
     * @Route("/{id}")
     */
    public function showTableau(Request $request, $id)
    {
        // Récupération d'une ligne de la table Tableau correspondant à l'id
        $onetableau = $this->getDoctrine()->getRepository(Tableau::class)->find($id);

        // Message d'erreur si je n'ai pas trouvé la ligne, donc base non initialisée
       if (!$onetableau) {
           throw $this->createNotFoundException(
              "Pas de tableau trouvé avec l'id  " . $id . " en base de données"
           );
        }

        return $this->render('galerie/tableau.html.twig', [
            'controller_name' => 'TableauController',
           'tableau'=>$onetableau
        ]);
    }

}
