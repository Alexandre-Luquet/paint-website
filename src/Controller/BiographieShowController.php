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
        $id = 1;
        // Récupération de la première ligne de la table biographie (1 seul enregistrement prévu)
        $bio = $this->getDoctrine()
            ->getRepository(Biographie::class)
            ->find($id);

        // Message d'erreur si je n'ai pas trouvé la ligne, donc base non initialisée
        if (!$bio) {
            throw $this->createNotFoundException(
                "Pas de biographie trouvée avec l'id  " . $id . " en base de données"
            );
        }

        $image = $bio->getPhoto();
        $texte = $bio->getDescription();

        //return new Response('<strong>Photo employée pour la biographie : </strong>'. $image.
        //'<br><strong>Le contenu de la biographie : </strong>' . $texte);

        return $this->render('biographie/index.html.twig', [
            'controller_name' => 'BiographieController',
            'image' => $image,
            'texte' => $texte,
            'alt' => "Photo de l'artiste",
        ]);
    }
}
