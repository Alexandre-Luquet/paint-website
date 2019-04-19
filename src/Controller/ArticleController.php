<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/article")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {
        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();

        return $this->render('article/index.html.twig',
            [
                'articles' => $articles,
            ]
        );
    }

    /**
     * @Route("/{id}")
     */
    public function showExposition($id)
    {
        // Récupération d'une ligne de la table Exposition correspondant à l'id
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

        // Message d'erreur si je n'ai pas trouvé la ligne, donc base non initialisée
        if (!$article) {
            throw $this->createNotFoundException(
                "Pas d'article trouvé avec l'id  " . $id . " en base de données"
            );
        }

        return $this->render('article/article.html.twig',
            [
                'exposition' => $article
            ]);

    }
}
