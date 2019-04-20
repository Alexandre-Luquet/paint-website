<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Entity\Tableau;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @Route("/{id}")
     */
    public function index(Tableau $tableau)
    {
        return $this->render(
            'admin/comment/index.html.twig',
            [
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
            'app_admin_comment_index',
            [
                'id' => $tableauId
            ]
        );
    }
}
