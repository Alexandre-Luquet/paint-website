<?php
//okok
namespace App\Controller;

use App\Entity\Biographie;
use App\Entity\Tableau;
use App\Form\ContactType;
use Doctrine\ORM\Mapping\Index;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request; //néccessaire pour faire une requête?
//use Symfony\Component\HttpFoundation\Response; //test1
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {
       // $caroussel = true;
        //$caroussel = $this->getDoctrine()-> getRepository(Tableau::class)->findByImage
        //('Joconde');



        //$repository = $this->getDoctrine()
          //  ->getManager()
            //->getRepository('SdzBlogBundle:Article');
        //$article = $repository->findOneBy(array('titre' => 'Mon dernier weekend'));
// $article est une instance de Article


        return $this->render('index/index.html.twig');
            //[
             //   'caroussel' => $caroussel
           //]);
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
