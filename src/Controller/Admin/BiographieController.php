<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;

// use nécessaire pour faire une réponse de "test"
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;

// use nécessaire pour faire une requête en base de données
use App\Repository\BiographieRepository;
use App\Entity\Biographie;
// use nécessaire pour le formulaire de saisie
use App\Form\BiographieType;


class BiographieController extends AbstractController
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

    /**
     * @Route("/biographie/edit")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function edit(
        Request $request
    ){

        //$biographie= new Biographie();
        $id = 1;
        $biographie = $this->getDoctrine()
            ->getRepository(Biographie::class)
            ->find($id);

        if (is_null($biographie)) {
            $biographie = new Biographie();
        }

        if(!is_null($biographie->getPhoto())) {
            // nom du fichier venant de la bdd
            $originalImage = $biographie->getPhoto();

            // on sette l'image avec un objet file sur l'emplacement de l'image pour le traitement par le formulaire
            $biographie->setPhoto(
                new File($this->getParameter('biographie_directory') . $originalImage)
            );
dump($biographie->getPhoto());
        }



        $form = $this->createForm(BiographieType::class, $biographie);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if($form->isValid()){
                //$directory = "images/biographie";
                //$newFilename = "photo.jpg";

                // Traitement de la photo : recopie du fichier dans le répertoire images puis chemin d'accès dans le champ photo
                /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
                //$file = $biographie->getPhoto();
                $file = $form['photo']->getData();
                if(!is_null($file)) {
                    $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();

                    $file->move(

                        $this->getParameter('biographie_directory'),
                        $fileName
                    );


                    // updates the 'brochure' property to store the PDF file name
                    // instead of its contents
                    $biographie->setPhoto($fileName);

                    if (!is_null($originalImage)) {
                        unlink($this->getParameter('biographie_directory') . $originalImage);
                    }
                    //$biographie->setPhoto($this->getParameter('biographie_directory') . $fileName);
                } else{
                    // en modif, sans upload, on sette l'attribut image avec le nom de l'ancienne image
                    $biographie->setPhoto($originalImage);
                }

                // Enregistre en base les données issues du formulaire
                $em = $this->getDoctrine()->getManager();
                $em->persist($biographie);
                $em->flush();

                // Redirection vers la page de la biographie
                return $this->redirectToRoute('app_admin_biographie_show');

            }else{
                // Affichage du message d'erreur
                $this->addFlash('error', 'Un problème a été rencontré lors du traitement de votre demande');
            }
        }

        // Si pas de formulaire 'soumis' afficher le formulaire de mise à jour / saisie
        return $this->render('Admin/biographie/input.html.twig',
            [
                'form' => $form->createView(),
                'original_image' => $originalImage
            ]
        );
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
}
