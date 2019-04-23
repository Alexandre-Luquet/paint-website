<?php

namespace App\Controller\Admin;

use App\Entity\Tableau;
use App\Form\TableauType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TableauController
 * @package App\Controller\Admin
 * @Route("/tableau")
 */
class TableauController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(){

        $repository = $this->getDoctrine()->getRepository(Tableau::class);

        $tableaux = $repository->findBy([], ['publicationDate' => 'DESC']);

        //$searchForm = $this->createForm(SearchTableauType::class);

        //$searchForm->handleRequest($request);

        //$tableaux = $repository->search((array)$searchForm->getData());

        return $this->render('admin/tableau/index.html.twig',
            [
                'tableaux' => $tableaux,
                //'search_form' => $searchForm->createView()
            ]);

    }
    /**
     * @Route("/edition/{id}", defaults={"id":null}, requirements={"id": "\d+"})
     */
    public function edit(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $originalImage =null;

        if (is_null($id)) { // création
            $tableau = new Tableau();
            $tableau->setPublicationDate(new \DateTime());
        } else { // modifications
            $tableau = $em->find(Tableau::class, $id);

            // 404 si id recu dans url n'est pas dans la bdd
            if (is_null($tableau)) {
                throw new NotFoundHttpException();
            }

            if(!is_null($tableau->getImage())) {
                // nom du fichier venant de la bdd
                $originalImage = $tableau->getImage();

                // on sette l'image avec un objet file sur l'emplacement de l'image pour le traitement par le formulaire
                $tableau->setImage(
                    new File($this->getParameter('galerie_directory') . $originalImage)
                );

            }
        }

        //création du formaulaire lié a la categorie
        $form = $this->createForm(TableauType::class, $tableau);

        //le formulaire analyse la requete et fait le mapping avec l'entité s'il a ete soumis
        $form->handleRequest($request);


        // si le formulaire a ete soumis
        if ($form->isSubmitted()) {

            if ($form->isValid()) {
                /** @var UploadedFile $image */
                $image = $form->get('image')->getData();

                if(!is_null($image)) {
                    // nom sous lequel va etre enregistre l'image
                    $filename = uniqid() . '.' . $image->guessExtension();

                    // déplace l'image uploadée
                    $image->move(
                    // vers le repertoire /public/images
                    //cf config/services.yaml
                        $this->getParameter('galerie_directory'),
                        $filename
                    );

                    //on sette l'attribut image de l'article avec son nom pour enregistrement bdd
                    $tableau->setImage($filename);

                    //en modification on supprime l'ancienne s'il y en a une
                    if (!is_null($originalImage)) {
                        unlink($this->getParameter('galerie_directory') . $originalImage);
                    }
                }else{
                    // en modif, sans upload, on sette l'attribut image avec le nom de l'ancienne image
                    $tableau->setImage($originalImage);
                }
                // enregistrement en bdd
                $em->persist($tableau);
                $em->flush();
                // confirmation
                $this->addFlash('success', "L'oeuvre est bien enregistrée");
                //redirection vers la page de liste
                return $this->redirectToRoute('app_admin_tableau_index');
            } else {
                $this->addFlash('error', 'Le formulaire contient des erreurs');
            }
        }

        return $this->render('admin/tableau/edit.html.twig',
            [
                //passage du formulaire au template
                'form' => $form->createView(),
                'original_image' => $originalImage
            ]
        );
    }

    /**
     * @Route("/suppression/{id}")
     */
    public function delete(Tableau $tableau){
        $em = $this->getDoctrine()->getManager();

        // si l'article a une image on la supprime
        if (!is_null($tableau->getImage())){
            unlink($this->getParameter('galerie_directory').$tableau->getImage());
        }

        $em->remove($tableau);
        $em->flush();

        $this->addFlash('success', "Le tableau a bien été supprimé");

        return $this->redirectToRoute('app_admin_tableau_index');
    }

    /**
     *
     * @Route("/ajax/request/{id}")
     */
    public function ajaxRequest(Request $request, Tableau $tableau)
    {

        //if ($request->isXmlHttpRequest()) {

            return $this->render(
                'admin/tableau/ajax_request.html.twig',
                [
                    'tableau' => $tableau
                ]
            );
//        } else {
//            throw new NotFoundHttpException();
//        }
    }
}
