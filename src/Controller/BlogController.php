<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Blog;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/blog")
 */
class BlogController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {
        $blogs = $this->getDoctrine()->getRepository(Blog::class)->findAll();

        return $this->render('blog/index.html.twig',
            [
                'blogs' => $blogs,
            ]
        );
    }

    /**
     * @Route("/{id}")
     */
    public function showBlog($id)
    {
        // Récupération d'une ligne de la table Exposition correspondant à l'id
        $blog = $this->getDoctrine()->getRepository(Blog::class)->find($id);

        // Message d'erreur si je n'ai pas trouvé la ligne, donc base non initialisée
        if (!$blog) {
            throw $this->createNotFoundException(
                "Pas d'article trouvé avec l'id  " . $id . " en base de données"
            );
        }

        return $this->render('blog/blog.html.twig',
            [
                'blog' => $blog
            ]);

    }
}