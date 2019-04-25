<?php
namespace App\Controller;

use App\Entity\Biographie;
use App\Entity\Selection;
use App\Entity\Tableau;
use App\Form\ContactType;
use Doctrine\ORM\Mapping\Index;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {

        // Récupération des éléments nécessaires pour la page d'accueil

        /**
         * Récupération des informations nécessaires pour la biographie
         * Utilisation d'une requête PERSONNALISEE pour trouver le dernier id de la table Biographie
        */
        $bio = $this->getDoctrine()
            ->getRepository(Biographie::class)
            ->findLastId();

        /**
         * Recuperation des tableaux devant servir à construire le carrousel
         * On utilise l'attribut de la base de données dédié (carrousel = booleen)
        */
        $carrousel = $this->getDoctrine()
            -> getRepository(Tableau::class)
            ->findByCarrousel(1);

        /**
         * Recuperation des tableaux à afficher dans "Ma sélection" via l'objet "Selection"
         */
        $selection = $this->getDoctrine()->getRepository(Selection::class)->find(1);




        return $this->render('index/index.html.twig',
            [
                'tableauxCarrousel' => $carrousel,
                'biographie' => $bio,
                'selectionA'=> $selection->getTableau1(),//$selection contient le 4 quadri et ici je récupére le premier
                'selectionB'=> $selection->getTableau2(),
                'selectionC'=>$selection->getTableau3(),
                'selectionD'=>$selection->getTableau4(),
            ]);
    }



    /**
     * @Route("/contact")
     */
    public function contact(Request $request, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(ContactType::class);

        if (!is_null($this->getUser())) {
            // préremplissage formulaire
            $form->get('name')->setData($this->getUser());
            $form->get('email')->setData($this->getUser()->getEmail());
        }

        $form->handleRequest($request);

        if ($form->isSubmitted()){
            if ($form->isValid()){
                $data = $form->getData();

                $mail = $mailer->createMessage();

                $mailBody = $this->renderView(
                    'index/contact_body.html.twig',
                    [
                        'data' => $data
                    ]
                );

                $mail
                    ->setSubject('Nouveau message sur votre blog')
                    ->setFrom('contact@blog.fr')
                    ->setTo('contact@bog.fr')
                    ->setBody($mailBody)
                    ->setReplyTo($data['email'])
                ;
                $mailer->send($mail);

                $this->addFlash('success', 'Votre message est bien envoyé');

            }else{
                $this->addFlash('error','Le formulaire contient des erreurs');
            }
        }

        return $this->render(
            'index/contact.html.twig',
            [
                'form' => $form->createView()
            ]
        );

    }
}
