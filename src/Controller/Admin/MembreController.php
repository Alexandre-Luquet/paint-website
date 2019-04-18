<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\MembreType;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/membre")
 */
class MembreController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(User::class);

        $users = $repository->findBy([], ['id' => 'ASC']);
        return $this->render('admin/membre/index.html.twig',
            [
                'users' => $users
            ]);
    }

    /**
     * {id} est optionel, vaut null par defaut et doit etre un nombre
     * @Route("/edition/{id}", defaults={"id":null}, requirements={"id": "\d+"})
     */
    public function edit(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();

        if (is_null($id)) { // création
            $user = new User();
        } else { // modifications
            $user = $em->find(User::class, $id);

            // 404 si id recu dans url n'est pas dans la bdd
            if (is_null($user)) {
                throw new NotFoundHttpException();
            }
        }

        //création du formulaire lié a l'utilisateur
        $form = $this->createForm(MembreType::class, $user);

        //le formulaire analyse la requete et fait le mapping avec l'entité s'il a ete soumis
        $form->handleRequest($request);

        //dump($user);

        // si le formulaire a ete soumis
        if ($form->isSubmitted()) {

            if ($form->isValid()) {
                // enregistrement en bdd
                $em->persist($user);
                $em->flush();
                // confirmation
                $this->addFlash('success', "L'utilisateur à bien été modifié");
                //redirection vers la page de liste
                return $this->redirectToRoute('app_admin_membre_index');
            } else {
                $this->addFlash('error', 'Le formulaire contient des erreurs');
            }
        }

        return $this->render('admin/membre/edit.html.twig',
            [
                //passage du formulaire au template
                'form' => $form->createView()
            ]
        );
    }
    /**
     * @Route("/suppression/{id}")
     */
    public function delete(User $user){

        $em = $this->getDoctrine()->getManager();

        $em->remove($user);
        $em->flush();

        $this->addFlash('success', "L'utilisateur a bien été supprimé");

        return $this->redirectToRoute('app_admin_membre_index');
    }
}