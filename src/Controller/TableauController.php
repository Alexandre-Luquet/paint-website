<?php

namespace App\Controller;

use App\Entity\Tableau;
use App\Entity\Comment;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/tableau")
 */
class TableauController extends AbstractController
{
    /**
     * @Route("/")
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
    public function showTableau(
        Request $request,
        EntityManagerInterface $em,
        Tableau $tableau)
    {

        /*
         * Sous le tableau, si l'utilisateur n'est pas connecté,
         * l'inviter à le faire pour pouvoir écrire un commentaire.
         * Sinon, lui afficher un formulaire avec un textarea
         * pour pouvoir écrire un commentaire.
         *
         * Lister les commentaires en dessous, avec nom utilisateur,
         * date de publication, contenu du message
         */
        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $comment
                    ->setDatePublication(new \DateTime())
                    ->setTableau($tableau)
                    ->setUser($this->getUser());


                $em->persist($comment);
                $em->flush();

                $this->addFlash('success', 'Votre commentaire est enregistré');

                return $this->redirectToRoute(
                // la route de la page courante
                    $request->get('_route'),
                    [
                        'id' => $tableau->getId(),
                    ]
                );
            } else {
                $this->addFlash('error', 'Le formulaire contient des erreurs');
            }
        }


        return $this->render(
            'galerie/tableau.html.twig',
            [
                'tableau' => $tableau,
                'form' => $form->createView(),
            ]);
    }
    /**
     *
     * @Route("/ajax/request/{id}")
     */
    public function ajaxRequest(Request $request, Tableau $tableau)
    {

        if ($request->isXmlHttpRequest()) {

            return $this->render(
                'galerie/ajax_request.html.twig',
                [
                    'tableau' => $tableau
                ]
            );
        } else {
            throw new NotFoundHttpException();
        }
    }
}
