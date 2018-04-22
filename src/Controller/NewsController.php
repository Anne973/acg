<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Created by PhpStorm.
 * User: Anne
 * Date: 21/04/2018
 * Time: 15:25
 */
class NewsController extends Controller
{
    /**
     * @Route("actualites", name="actualites")
     */
    public function indexAction(){
        return $this->render('news/actualites.html.twig');

    }


}