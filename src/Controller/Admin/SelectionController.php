<?php

namespace App\Controller\Admin;

use App\Entity\Selection;
use App\Form\SelectionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/selection")
 */
class SelectionController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(Request $request)
    {
        $selection = $this->getDoctrine()
            ->getRepository(Selection::class)
            ->find(1);


        if (empty($selection)) {
            $selection = new Selection();
        }

        $form = $this->createForm(SelectionType::class, $selection);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if($form->isValid()) {
                // Enregistre en base les données issues du formulaire
                $em = $this->getDoctrine()->getManager();
                $em->persist($selection);
                $em->flush();

                // Redirection
                return $this->redirectToRoute('app_admin_tableau_index');

            }else{
                // Affichage du message d'erreur
                $this->addFlash('error', 'Un problème a été rencontré lors du traitement de votre demande');
            }
        }

        return $this->render('Admin/selection/index.html.twig',
            [
                'form' => $form->createView(),
            ]);
    }
}
