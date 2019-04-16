<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Form\SearcharticleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/article")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Article::class);

        //$articles = $repository->findBy([], ['publicationDate' => 'DESC']);

        $searchForm = $this->createForm(SearchArticleType::class);

        $searchForm->handleRequest($request);

        //dump($searchForm->getData());

        $articles = $repository->search((array)$searchForm->getData());

        return $this->render('admin/article/index.html.twig',
            [
                'articles' => $articles,
                'search_form' => $searchForm->createView()
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
            $article = new Article();
            $article->setDatePublication(new \DateTime());
        } else { // modifications
            $article = $em->find(Article::class, $id);

            // 404 si id recu dans url n'est pas dans la bdd
            if (is_null($article)) {
                throw new NotFoundHttpException();
            }

            if(!is_null($article->getImage())) {
                // nom du fichier venant de la bdd
                $originalImage = $article->getImage();

                // on sette l'image avec un objet file sur l'emplacement de l'image pour le traitement par le formulaire
                $article->setImage(
                    new File($this->getParameter('article_directory') . $originalImage)
                );

            }
        }

        //création du formulaire lié a la categorie
        $form = $this->createForm(ArticleType::class, $article);

        //le formulaire analyse la requete et fait le mapping avec l'entité s'il a ete soumis
        $form->handleRequest($request);


        // si le formulaire a ete soumis
        if ($form->isSubmitted()) {

            if ($form->isValid()) {
                /** @var UploadedFile $image */
                $image = $article->getImage();

                if(!is_null($image)) {
                    // nom sous lequel va etre enregistre l'image
                    $filename = uniqid() . '.' . $image->guessExtension();

                    // déplace l'image uploadée
                    $image->move(
                    // vers le repertoire /public/images
                    //cf config/services.yaml
                        $this->getParameter('article_directory'),
                        $filename
                    );

                    //on sette l'attribut image de l'article avec son nom pour enregistrement bdd
                    $article->setImage($filename);

                    //en modification on supprime l'ancienne s'il y en a une
                    if (!is_null($originalImage)) {
                        unlink($this->getParameter('article_directory') . $originalImage);
                    }
                }else{
                    // en modif, sans upload, on sette l'attribut image avec le nom de l'ancienne image
                    $article->setImage($originalImage);
                }
                // enregistrement en bdd
                $em->persist($article);
                $em->flush();
                // confirmation
                $this->addFlash('success', "L'article est bien enregistré");
                //redirection vers la page de liste
                return $this->redirectToRoute('app_admin_article_index');
            } else {
                $this->addFlash('error', 'Le formulaire contient des erreurs');
            }
        }

        return $this->render('admin/article/edit.html.twig',
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
    public function delete(Article $article){
        $em = $this->getDoctrine()->getManager();

        // si l'article a une image on la supprime
        if (!is_null($article->getImage())){
            unlink($this->getParameter('upload_dir').$article->getImage());
        }

        $em->remove($article);
        $em->flush();

        $this->addFlash('success', "L'article a bien été supprimé");

        return $this->redirectToRoute('app_admin_article_index');
    }
}
