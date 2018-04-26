<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArticleController extends Controller
{
    /**
     * @Route("actualites/{page}", name="actualites")
     */
    public function indexAction($page = 1, ArticleRepository $articleRepository){
        if ($page < 1) {
            throw $this->createNotFoundException("La page " . $page . " n'existe pas.");
        }

        $nbPerPage = Article::ARTICLES_PER_PAGE;

        $listArticles = $articleRepository->getArticles($page, $nbPerPage);

        $nbPages = ceil(count($listArticles) / $nbPerPage);

        if ($page > $nbPages) {
            throw $this->createNotFoundException("La page " . $page . " n'existe pas.");
        }

        return $this->render('Article/index.html.twig', array('listArticles' => $listArticles, 'nbPages' => $nbPages, 'page' => $page));
    }

    /**
     * @param Article $article
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/article/{id}", name="article")
     */
    public function articleAction(Article $article, ArticleRepository $articleRepository )
    {
        $lastArticles = $articleRepository -> getArticlesInHomepage();
        return $this->render('Article/article.html.twig', array('article' => $article, 'lastArticles' =>$lastArticles));

    }

}
