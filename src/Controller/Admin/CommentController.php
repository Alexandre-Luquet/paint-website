<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Entity\Tableau;
use App\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CommentController
 * @package App\Controller\Admin
 *
 * @Route("/commentaire")
 */
class CommentController extends AbstractController
{

    /**
     * @Route("/")
     */
    public function list()
    {
        $repository = $this->getDoctrine()->getRepository(Comment::class);

        $comments = $repository->findBy([], ['tableau' => 'ASC']);
        return $this->render('admin/comment/list.html.twig',
            [
                'comments' => $comments
            ]);
    }
    /**
     * @Route("/edit/{id}")
     */
    public function edit(Request $request, $id, Tableau $tableau)
    {
        $em = $this->getDoctrine()->getManager();

        $comment = $em->find(Comment::class, $id);

        // 404 si id recu dans url n'est pas dans la bdd
        if (is_null($comment)) {
            throw new NotFoundHttpException();
        }

        //création du formulaire lié a la categorie
        $form = $this->createForm(CommentType::class, $comment);

        //le formulaire analyse la requete et fait le mapping avec l'entité s'il a ete soumis
        $form->handleRequest($request);


        // si le formulaire a ete soumis
        if ($form->isSubmitted()) {

            if ($form->isValid()) {

                // enregistrement en bdd
                $em->persist($comment);
                $em->flush();
                // confirmation
                $this->addFlash('success', "Le commentaire est bien modifié");
                //redirection vers la page de liste
                return $this->redirectToRoute('app_admin_comment_list');
            } else {
                $this->addFlash('error', 'Le formulaire contient des erreurs');
            }
        }

        return $this->render('Admin/comment/index.html.twig',
            [
                //passage du formulaire au template
                'form' => $form->createView(),
                'tableau' => $tableau
            ]
        );
    }

    /**
     * @Route("/suppression/{id}")
     */
    public function delete(Comment $comment)
    {
        $em = $this->getDoctrine()->getManager();

        $tableauId = $comment->getTableau()->getId();

        $em->remove($comment);
        $em->flush();

        $this->addFlash('success', "Le commentaire est supprimé");

        return $this->redirectToRoute(
            'app_admin_comment_list',
            [
                'id' => $tableauId
            ]
        );
    }
}
