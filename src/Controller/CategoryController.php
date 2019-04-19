<?php

namespace App\Controller;


use App\Entity\Article;
use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CategoryController
 * @package App\Controller\Admin
 *
 * @Route("/categorie")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/{id}")
     */
    public function index(Category $category)
    {
        $repository = $this->getDoctrine()->getRepository(Article::class);
        $articles = $repository->findBy(
            [
                'category' => $category
            ],
            [
                'datePublication' => 'DESC'
            ],
            5
        );
        return $this->render('category/index.html.twig',
            [
                'category' => $category,
                'articles' => $articles
            ]
        );
    }
}