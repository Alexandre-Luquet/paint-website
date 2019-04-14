<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

// use nécessaire pour faire une réponse de "test"
use Symfony\Component\HttpFoundation\Response;

// use nécessaire pour faire une requête en base de données
use App\Repository\BiographieRepository;
use App\Entity\Biographie;

class BiographieController extends AbstractController
{
    /**
     * @Route("/biographie", name="biographie")
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

        return new Response('<strong>Photo employée pour la biographie : </strong>'. $image.
            '<br><strong>Le contenu de la biographie : </strong>' . $texte);

        return $this->render('biographie/index.html.twig', [
            'controller_name' => 'BiographieController',
            'image' => $image,
            'texte' => $texte,
            'alt' => "Photo de l'artiste",
        ]);
    }
}
