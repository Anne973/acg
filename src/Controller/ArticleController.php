<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\EventRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArticleController extends Controller
{
    /**
     * @Route("actualites/{page}", name="actualites")
     */
    public function indexAction($page = 1, ArticleRepository $articleRepository, EventRepository $eventRepository)
    {
        if ($page < 1) {
            throw $this->createNotFoundException("La page " . $page . " n'existe pas.");
        }

        //dump($articleRepository->search('provinciae bello'));

        $nbPerPage = Article::ARTICLES_PER_PAGE;

        $listArticles = $articleRepository->getArticles($page, $nbPerPage);

        $nbPages = ceil(count($listArticles) / $nbPerPage);

        if ($page > $nbPages) {
            throw $this->createNotFoundException("La page " . $page . " n'existe pas.");
        }

        $listEvents = $eventRepository->getEventsInArticlePage();

        return $this->render('article/index.html.twig', array(
            'listArticles' => $listArticles,
            'nbPages' => $nbPages,
            'page' => $page,
            'listEvents' => $listEvents));
    }

    /**
     * @param Article $article
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/article/{id}", name="article")
     */
    public function articleAction(Article $article, ArticleRepository $articleRepository)
    {
        $lastArticles = $articleRepository->getArticlesInHomepage();
        return $this->render('article/article.html.twig', array('article' => $article, 'lastArticles' => $lastArticles));

    }

    /**
     * @Route("search", name="search")
     */
    public function searchAction(Request $request, ArticleRepository $articleRepository)
    {
        $key = $request->get('key');
        if (strlen($key) > 2) {
            $listResults = $articleRepository->search($key);
            $nbResults = count($listResults);
            return $this->render('article/searchView.html.twig', array('listResults' => $listResults, 'key' => $key, 'nbResults' => $nbResults));
        } else {
            $this->addFlash('notice', 'Veuillez entrer au moins trois caractères');
            return $this->redirectToRoute('actualites');

        }
    }

}
