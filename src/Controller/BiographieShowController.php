<?php

namespace App\Controller;

use App\Entity\Biographie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class BiographieShowController extends AbstractController
{
    /**
     * @Route("/biographie")
     */
    public function show()
    {
        // Utilisation d'une requête personnalisée pour trouver le dernier id de la table
        $bio = $this->getDoctrine()
            ->getRepository(Biographie::class)
            ->findLastId();

        // Message de remplacement si je n'ai pas trouvé la ligne, donc base non initialisée
        if (!$bio) {
            $bio = new Biographie();
            $bio->setDescription("Aucune biographie saisie, bien vouloir la saisir en tant qu'administrateur via le bouton 'Modifier'");
        }

        $image = $bio->getPhoto();
        $texte = $bio->getDescription();

        return $this->render('biographie/index.html.twig', [
            'controller_name' => 'BiographieController',
            'image' => $image,
            'texte' => $texte,
            'alt' => "Photo de l'artiste",
        ]);
    }
}
